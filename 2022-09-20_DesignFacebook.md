Design a simple model of Facebook where people can add other people as friends. In addition, where people can post messages and that messages are visible on their friend's page. The design should be such that it can handle 10M of people. There may be, on an average 100 friends each person has. Every day each person posts around 10 messages on an average.

Use Case

    A user can create their own profile.
    A user can add other users to his friend list.
    Users can post messages to their timeline.
    The system should display posts of friends to the display board/timeline.
    People can like a post.
    People can share their friends post to their own display board/timeline.

Constraints

    Consider a whole network of people as represented by a graph. Each person is a node and each friend
    relationship is an edge of the graph.
    Total number of distinct users / nodes: 10 million
    Total number of distinct friend’s relationship / edges in the graph: 100 * 10 million
    Number of messages posted by a single user per day: 10
    Total number of messages posted by the whole network per day: 10 * 10 million

Basic Design

Our system architecture is divided into two parts:

    First, the web server that will handle all the incoming requests.
    The second database, which will store the entire person's profile, their friend relations and posts.

First, three requirements creating a profile, adding friends, posting messages are written some information
to the database. While the last operation is reading data from the database.

The system will look like this:

    Each user will have a profile.
    There will be a list of friends in each user profile.
    Each user will have their own homepage where his posts will be visible.
    A user can like any post of their friend and that likes will reflect on the actual message shared by his
    friend.

If a user shares some post, then this post will be added to the user home page and all the other friends of
the user will see this post as a new post.

Bottleneck

A number of requests posted per day is 100 million. Approximate some 1000 request are posted per
second. There will be an uneven distribution of load so the system that we will design should be able to
handle a few thousand requests per seconds.

Scalability

Since there is, a heavy load we need horizontal scaling many web servers will be handling the requests.
In doing this we need to have a load balancer, which will distribute the request among the servers.
This approach gives us a flexibility that when the load increases, we can add more web servers to handle
the increased load.
These web servers are responsible for handling new post added by the user. They are responsible for
generating various user homepage and timeline pages. In our case, the client is the web browser,
which is rendering the page for the user.

We need to store data about user profile, Users friend list, User-generated posts, User like statues to the
posts.
Let us find out how much storage we need to store all this data. The total number of users 10 million. Let
us suppose each user is using Facebook for 5 to 6 years, so the total number of posts that a user had
produced in this whole time is approximately 20,000 million or 20 billion. Let us suppose each message
consists of 100 words or 500 characters. Let us assume each character take 2 bytes.

Total memory required = 20 * 500 * 2 billion bytes.
= 20,000 billion bytes
= 20, 000 GB
= 20 TB
1 gigabyte (GB) = 1 billion bytes
1000 gigabytes (GB) = 1 Terabytes 

Most of the memory is taken from the posts and the user profile and friend list will take nominal as
compared with the posts. We can use a relational database like SQL to store this data. Facebook and
twitter are using a relational database to store their data.

Responsiveness is key for social networking site. Databases have their own cache to increase their
performance. Still database access is slow as databases are stored on hard drives and they are slower
than RAM. Database performance can be increased by replication of the database. Requests can be
distributed between the various copies of the databases.

Also, there will be more reads then writes in the database so there can be multiple slave DB which are
used for reading and there can be few master DB for writing. Still database access is slow to we will use
some caching mechanism like Memcached in between application server and database. Highly popular
users and their home page will always remain in the cache.

There may be the case when the replication no longer solves the performance problem. In addition, we
need to do some Geo-location based optimization in our solution.
Again, look for a complete diagram in the scalability theory section.
If it were asked in the interview how you would store the data in the database. The schema of the
database can look like:

Table Users:

1. User Id
2. First Name
3. Last Name
4. Email
5. Password
6. Gender
7. DOB
8. Relationship

Table Posts:

1. Post Id
2.  Author Id
3.  Date of Creation
4.  Content

Table Friends:

1. Relation Id
2. First Friend Id
3. Second Friend Id

Table Likes:

1. Id
2. Post Id
3. User Id


------------------------------------------------------------
------------------------------------------------------------

Design Facebook

Requirements:
Add Friend
Post messages and show on friends timeline
10M users
Avg 100 friends of each user
Avg 10 messages/day each user

Use Case:
1. create user profile - write to DB
2. add other users as friends - write to DB
3. post messages on my timeline - write to DB
4. on newsfeed show friends posts - read to DB
5. like post - write
6. Share post - write

Constraints:
nodes: 10M
edges: 100*10M
posts: 10*10M/day

Basic Design:
1. Web servers for handling incoming requests
2. DataBase to store profiles, friends-list, posts

Profile(friendsList, timeline)
Likes visible on post
Share post - show on friends timeline as new post

Bottleneck:(Read Heavy)
Write requests/day: 100M/day ==> 1000 req/sec
Read requests/day: 10*100*10 ==> 10000M/day

Scalability:
Horizontal Scaling
LoadBalancer

Databases:
Store: Profile, FriendsList, Posts, Likes
Time: 5-6 years of 
10M users     
Total Posts: 5*365=2000 days * 100M/day = 200B posts
Each message: 100 or 500 chars
Bytes/char = 2
Total Storage = 200*500*2 B bytes = 200000 BBytes
= 200000GB = 200TB for posts

SQL DB
DB caches, DB repication
Master DB - write
Slave DB - read
Memory Cache - Memcache b/w application and Database
(Memcache used for Popular/trending profiles/post)



how to present to users the timeline (newsfeed generation for your friends). If also this was a key point of the interview you should talk a little about it. It's obvious that you cannot generate news feed on the fly when users connect, it would be too slow.
One solution is to have some worker jobs which asynchronously generates the news feed for each user and cache them (scheduled once a day).
Then a new issue pop up: you would like to have a more responsive system instead of wait one day to have the updates. The solution is to have a queue (probably multiple of them) where you keep track of the news feed to be updated based on the friends list of the users which post messages: when you post a message you also trigger the generation of the news feed for your friends.
Then again a new issue pop up: what's about celebrities which has a lot of friends? One possible approach could be to rank their friends based on the frequency that they are accessing to Facebook home page and trigger only frequent users, updating the other users news feed using only the scheduled job.



trickiest parts of FB are how serve up the data at scale. For example, user A is very popular and is cached. They make updates to their account that they want someone to see asap, like a new profile pic. How does this work? Can we hit your target of ~1000 TPS with this in mind? Why or why not?

shard the mysql DB by last name, therefore giving you the perf you need, if needed.
You could also say you use write through caching, where writes populate the cache with updated information.

Another huge glaring issue is pagination and their "user feed" system. That home screen, where you load everyone's posts, pages and updates is a critical component of how FB is designed. Figuring that out, and designing something that feeds you almost endless amount of information is a big challenge.

 use a FanOut Service or an Aggregator which technically keeps records of all ur posts and based on ur number of friends add to their list based on timestamp. So every time , ur friend's list has all list of recent posts sorted in timestamp by the his friend circles. And for for a famous celebrity post always append it at top at last if they post anything.
Its just a simple vague idea so that you can search on it and read more.



Actually the core component in facebook design is handling the friends list and timeline generation I believe. How can we handle these efficiently is a plus point.

    Like what data structure can be used to save relationship and which kind of db is well suited(sql, nosql etc).
    Also for timeline generation , If asynchronous queue can be used for pushing post to friends list since user can see notification immediately about his post but it is okay if system takes time to propagate post to a friends list.
    Also the caching criteria like instead of caching highly popular user and its homepage(Which will be needed frequently only if user logins frequently), I would like to cache 10% of the popular posts since it will be seen by many users.(Using LRU policy for cache eviction).




