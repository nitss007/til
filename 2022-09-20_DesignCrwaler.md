Facebook | System Design | A web crawler that will crawl Wikipedia

We need to deploy the same software on each node. We have 10,000 nodes, the software can know about all the nodes. We have to minimize communication and make sure each node does equal amount of work.

Encountered this question in facebook.

My solution:
Intial Proposal:
Start out with the root page, and based on a hash function decide if that page is for you (the node) or not.

What if one node fails or does not work?
When encountering a page, ping to see whether the node handling that page is online, if not use a secondary hash function to determine alternate handler. If you are the alternate handler, handle the page, if not ping to see if the alternate handler is online. Do this for al hash functions you decide to have, more hash functions means less impact by failure of one node.

How do you know when the crawler is done?
Pass around a timestamp of the last crawled page. If the timestamp gets back to you without changing, then you are done.


In a System design question, understand the scope of the problem and stay true to the original problem.
The scope was to design a web crawler using available distributed system constructs and NOT to design a distributed database or a distributed cache.

A Web crawler system design has 2 main components:

    The Crawler (Write path)
    The Indexer (Read path)

Make sure you ask about expected number of URLs to crawl (Write QPS) and expected number of Query API calls (Read QPS).
Make sure you ask about the SLA for the Query API. If its in tens of milliseconds at say 90 percentile, you'll probably need to cache the query results and can we use a messaging queue like SQS?

Begin with these high level components, then break them down into smaller sub-components, then connect these to form a coherent whole.

Crawler

    For crawling you need a "seed of URLs" to begin the crawling. You'd want to put the URLs in a queue.
    The queue workers would work on one URL at a time. Each queue worker, given a URL has to:
    **Extract text from the URL and send it to a Document Indexing Service .
    **Insert any links found in the page back into the queue. Before inserting, the links are looked up (and stored) in a Global NoSql store, to ensure they weren't already crawled. We use a NoSql store (and not a SQL Database) because we're doing lookup operations only and don't require expensive joins.

Eventually the queue will become empty. At this point, the "seeder" will reseed the queue with seed URLs and the whole process restarts.

Scaling up the crawler (only if the websites to crawl are in billions):

    Your queue could be a distributed message queue (such as SQS or Azure ServiceBus).
    Your NoSql store could be DynamoDB.

The interviewer would most likely know that both message queues and NoSql stores maintain replicas (typically master-slave replication) for fault tolerance and re-partition themselves via an algorithm like consistent hashing for scalability.
All distributed queues have a Visibility Timeout i.e. when an element is dequeued, it still remains in the queue but is made invisible to other dequeue requests till Visibility Timeout seconds have elapsed. A worker that is handling the dequeued element must explicitly delete it from the queue before Visibility Timeout seconds.

Challenges for Crawler:

    How would you handle throttling from your NoSql store (say because you have too many crawlers attempting to lookup and write URLS to it)? If you try an exponential retry algorithm in your worker, your message queue may release the URL being already crawled to another worker.
    How would you handle dead links? You'd probably want to maintain a blacklist of links that returned 404 so that your workers don't put these in crawler queue the next time around.
    How do you handle crawling of temporarily offline websites. Assume that your worker connected to the website but it took 40 seconds to respond with 503 but by that time, your message queue already released the same URL to another worker who'd attempt to reconnect to the same website and suffer from the same fate.
    How would you handle websites that failed to get crawled? You'd probably want to store them in a Dead Letter Queue to be inspected later.
    Would you respect Robots.txt files while crawling? Maybe you could store the domain name + /* of such sites in the Blacklist NoSql Store.
    How would you throttle requests from your crawlers running in parallel to different pages on a single website (like Wikipedia). Maybe a message queue is not a right fit in this design? You could probably use a Streaming queue (like Kafka/Kinesis Streams/ Azure EventHub) where the domain name of the URL is the partition key. This means that all sub-URLs within a domain will be handled by one worker only. But this leads to obvious load balancing issues. Alternatively, you could invest in a Rate Limiter that ensures that one worker does not open more than n connections to a single website. But what is a good value of n? Wikipedia can probably handle thousands of concurrent connections but a small company's website could cave in. So the value on n depends on the domain being crawled and will need tweaking via trial and error. Which means you'll need another NoSql store that stores domain names and n which the RateLimiter will need to cache when doing the rate limiting. Next question: what should the worker do if the Rate Limiter disallowed it from accessing the URL? Should it keep retrying? If yes, what if the message queue releases the same URL to another worker? It makes sense for the worker to drop it and go for the next URL in the queue. This will cause the message queue to release this current URL to another worker after Visibility Timeout seconds, and that worker might have a higher chance of succeeding. But what if the next URL is also of the same domain?

All in all, you should also discuss what logs/metrics you'd emit and how these are analyzed to make the crawling better. Some metrics to emit would be how many times a worker was rate limited, latency of every operation (such as reading entire contents a URL, time taken for ranking the text, indexing it etc.). For websites that caved in or were unresponsive etc, apart from the metrics, you'd also write them in special log files which are then machine learned to produce the Blacklist NoSql store or to recompute the number of connections for a domain to be used by the Rate Limiter.

Indexer

    You'll need a Document Indexing Service that does 2 things on its write path:
    ** Insert the URL and its text into another NoSql store. This will be used for showing cached copies in case the original URLis unavailable or is dead. But what if the text is huge? In that case, it makes sense to store the text instead in an Object/Blob Store like S3/Azure Blob Storage under a key which is the hash of the URL.
    ** Maintain a Reverse Index that maps keywords/phrases in the text back to the original URL. You can use a Reverse Index database like Elastic Search.

The Document Indexing Service also exposes a query API that takes as input, a phrase + number of results (i.e. page size) to return. It would then break the phrase into keywords, remove "Stop words" (words like the, a, an etc), correct spelling mistakes in the keywords, add synonyms of certain keywords and then call into Elastic Search to return the URLs that contain these keywords. Elastic Search has plugins which already do spelling corrections, stop word removal etc. The URLs could then be fed into a Ranking service that ranks the URL before returning. If your Read QPS is higher than Write QPS, a better approach would be to do the ranking via an hourly offline process and store the rank in Elastic Search. That would speed up the querying path as you'd skip ranking and instead ask Elastic Search to return URLs sorted by rank. This also makes it easy to paginate as the first page will contain the top n results, the next page will contain the next n results etc. The hourly offline ranker would need what are called as "Clickstream logs" to figure out which links are being clicked more often so as to rank them higher.

The query API must also return a pagination token to allow the caller to continue retrieving more pages

Challenges for Indexer:

    Can we speed up the read path by maintaining a cache for most commonly queried phrases? The 80/20 rule states that 80% of users query the same 20% phrases. If so, what caching strategy to use? LRU/TTL? Should we go with a write through cache so that the crawler directly updates the cache? Or a cache-aside strategy where the cache is bypassed by the crawlers when they write to the Document Service? In that case, what TTL value would be appropriate for the cache?
    What kind of distributed cache would we use? Redis/memcached? Only if asked, you can mention about consistent hashing here.

That's about it...No consistent hashing/zookeeper etc required.

--> This is decent design. But will only get you to E3 at FB. This question as asked at FB, is about bringing out your distributed systems knowledge. Interviewer will cut short this discussion with one question/requirement after the first 5 mins - By introducing many components into system such as sqs, dynamo, s3 you have to allocate capacity to each of these components. How would decide which component needs more capacity ? what if many nodes of one type(say sqs) go down ? Will you pull some dynamo nodes and install sqs on them ? Do you see the problem here ? Each set of nodes has some specialized function, which makes it difficult to scale. If the nodes are homogenous, you can scale very easily. Read the first line - "We need to deploy the same software on each node"


Alternative:

Based on just the description of problem, I would say we dont even have to distinguish between crawling and indexing - each node has to do both !
I would design the system as:

Hash out Nodes into 2000 groups of 5 nodes each. Assuming wikipedia has 100 million URLs that need to be traversed.
Each node needs to process - 10k URLs (100 mill/10k nodes).
Now seed each of the 2k groups using some hash API. Use a 2nd level hash to still assign seeds within groups.
Let each node crawl for (say) 100 URLs (just build a list of 100 URLs, no indexing yet).
To avoid duplication, there is a central authority - Master per group which determines if worker node should go ahead indexing the data or not (I know I am assigning more work for this node, but i expect master to be rotating role between 5 nodes within group).
Each node generates a 6 byte hash of URL , and send 1000*6 = 6KB worth of data to master.
Assuming it takes 1 second to build 100 URL list(10 ms to open 1 URL and process it, 100X10ms = 1sec), each node would be sending 6KB/second.
Every second master node would receive (4nodes *6KB)24KB worth of data.
Master would do comparison between the hashes and remove duplicates from these lists and send the result back to each nodes.
With the now confirmed unique URLs - each node would go ahead and index the data (in some central DB?? )

As each node is responsible for only 10k URLs, entire wikipedia would be indexed in roughly 100 seconds.

Update:
De-duplication of URLs need to be done between groups as well. Continuing the same patten - each group-master node would send group hashed URLs to a central server. This server again would be a floating role and can be taken by some other node in next iteration.
So the cluster master would require - 30KB*2K clusters = 60MBps bandwidth.
Typical home network provide speed at 20MBps. Thus master server would take 3(60/20) seconds to collect all data.
And this needs to be done 100 times.
Thus in-total 300 seconds for master level de-duplication.
Thus total time taken at high level 100+300 seconds = ~7 minutes.

I see that in current shape, my design has single point of failure at master node.
I would say that 2000 groups could be divided into smaller super-groups which perform de-dup before reaching out to master node.
This will remove single point of failure and provide redundancy to architecture at the cost of increasing total scanning time.
But I believe we could still do the scanning with multiple-hierarchies in roughly under 20 minutes (by extrapolating above calculations).

Even if we use consistent-hashing, the question is how would all servers know about the updated list of servers? In case for example services are failing or being added? This can be achieved by either updating the list manually and redeploying to each server or using a centralized piece, e.g. ZK.
Then, if we use a centralized service, such as ZK, we can leverage it to know when all are done. Same as all are periodically sending heartbeat to ZK, they will also update once they're done. Once all are done, we know we're done.
Another approach - is that we do not care about services that fail and that no new servers are added. We can then treat it naively and assume that client library will direct to the next server in the consistent hash ring. BUT this will not provide full balance between all AND we will not know when we're done.

're on the right track regarding "Clickstream" logs. Essentially search engines like Google log which links from the search page you clicked. There are techniques for them to find out the "dwell time" (i.e. how long you stayed on the link you clicked) as well. The "dwell time" allows Google to figure out how relevant the link is to the keywords that were searched. If the link was clicked by mistake or is irrelevant you're likely to close the web page quickly and return to the Search page. Otherwise you'll dwell on that page for quite some time.

This information (keywords you typed + links you clicked + dwell time) is then fed into the *Ranker *. If the Ranker notices that many users are clicking the third link in the Search Query result for a set of keywords, and the "dwell time" is high, it will rank it higher. Eventually the most "relevant" link would be on top. At least that's the hope. Of course, Google's ranking looks at various other signals (many of them are proprietary secrets) but that's the gist. I'm guessing they also use your Google user name (if you're logged in) or your IP address to make the search results more of your taste ("personalization"). Ranking + personalization is a phenomenally complex problem and apart from ML algorithms, requires a large amount of user clickstream data to constantly train the AI to keep making it better. This large amount of user data gives Google the edge over other search engines like Bing, specially for unusual queries.


https://boston.lti.cs.cmu.edu/callan/Workshops/dir03/PapersPublished/singh.pdf

https://github.com/donnemartin/system-design-primer/blob/master/solutions/system_design/web_crawler/README.md
