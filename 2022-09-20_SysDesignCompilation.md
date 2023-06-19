Facebook

    https://leetcode.com/discuss/interview-question/1002218/Facebook-or-Google-or-Top-System-Design-Interview-Questions-(Part-1)
    https://leetcode.com/discuss/interview-question/1042229/Facebook-or-Google-or-Top-System-Design-Interview-Questions-(Part-2)
    https://leetcode.com/discuss/interview-question/719253/Design-Facebook-%3A-System-Design-Interview
    https://leetcode.com/discuss/interview-question/124657/Facebook-or-System-Design-or-A-web-crawler-that-will-crawl-Wikipedia

Google

    https://leetcode.com/discuss/interview-question/system-design/496042/Design-video-sharing-platform-like-Youtube
    https://leetcode.com/discuss/interview-question/system-design/733520/Design-YouTube-Very-detailed-design-with-diagrams
    https://leetcode.com/discuss/interview-question/system-design/318811/Google-or-System-design-or-Design-a-translation-service-like-Google-Translate
    https://leetcode.com/discuss/interview-question/system-design/692383/Google-or-Onsite-or-Design-a-organization-pharmacy-shop-with-managers

Amazon

    https://leetcode.com/discuss/interview-question/341980/Amazon-or-System-Design-or-System-to-capture-unique-addresses-in-the-entire-world
    https://leetcode.com/discuss/interview-question/system-design/124557/Amazon's-"Customers-who-bought-this-item-also-bought"-recommendation-system
    https://leetcode.com/discuss/interview-question/system-design/344524/Amazon-or-Design-a-JobTask-Scheduler
    https://leetcode.com/discuss/interview-question/373887/Amazon-or-System-Design-or-A-configuration-management-system

Uber

    https://leetcode.com/discuss/interview-question/124673/Design-a-Location-Sharing-Android-Application
    https://leetcode.com/discuss/interview-question/124542/Design-Uber-Backend
    https://leetcode.com/discuss/interview-question/system-design/124558/Uber-or-Rate-Limiter

Microsoft

    https://leetcode.com/discuss/interview-question/system-design/685310/Microsoft-virtual-or-Design-distributed-counter
    https://leetcode.com/discuss/interview-question/system-design/680047/How-will-you-store-millions-of-subscribers-list-(assume-it-as-email-id)
    https://leetcode.com/discuss/interview-question/system-design/598634/Microsoft-or-Onsite-or-System-Design-or-SDE-2

Others (Does not fall under any particular company):

    https://leetcode.com/discuss/general-discussion/1105898/System-Design%3A-Introduction-to-Distributed-Systems-or-Designing-a-highly-available-system
    https://leetcode.com/discuss/general-discussion/1114279/System-Design%3A-Introduction-to-Distributed-Systems-Pt.-2-or-Design-Highly-available-System
    https://leetcode.com/discuss/general-discussion/1082786/System-Design%3A-Designing-a-distributed-Job-Scheduler-or-Many-interesting-concepts-to-learn
    https://leetcode.com/discuss/general-discussion/1035779/System-Design-Reading-Resources
    https://leetcode.com/discuss/general-discussion/901324/My-System-Design-Interview-Checklist-A-Gateway-to-FAANGs
    https://leetcode.com/discuss/interview-question/124658/Design-URL-Shortening-service-like-TinyURL
    https://leetcode.com/discuss/interview-question/1061256/Tips-on-System-design-from-a-20%2B-YOE-Engineer
    https://leetcode.com/discuss/interview-question/system-design/566057/Machine-Learning-System-Design-%3A-A-framework-for-the-interview-day
    https://leetcode.com/discuss/interview-question/system-design/547669/Algorithm-you-should-know-before-system-design
    https://leetcode.com/discuss/interview-question/system-design/691010/System-Design-for-Mobile-App-Developers


##################################################################################################

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

--
how to present to users the timeline (newsfeed generation for your friends). If also this was a key point of the interview you should talk a little about it. It's obvious that you cannot generate news feed on the fly when users connect, it would be too slow.
One solution is to have some worker jobs which asynchronously generates the news feed for each user and cache them (scheduled once a day).
Then a new issue pop up: you would like to have a more responsive system instead of wait one day to have the updates. The solution is to have a queue (probably multiple of them) where you keep track of the news feed to be updated based on the friends list of the users which post messages: when you post a message you also trigger the generation of the news feed for your friends.
Then again a new issue pop up: what's about celebrities which has a lot of friends? One possible approach could be to rank their friends based on the frequency that they are accessing to Facebook home page and trigger only frequent users, updating the other users news feed using only the scheduled job.

d high level idea but the trickiest parts of FB are how serve up the data at scale. For example, user A is very popular and is cached. They make updates to their account that they want someone to see asap, like a new profile pic. How does this work? Can we hit your target of ~1000 TPS with this in mind? Why or why not?

In these situations, there's not really a right or wrong, but how you defend your ideas. Your job is to convince the interviewer that you know enough to put together a reasonably functioning system for the ask.

For example, you could say that you shard the mysql DB by last name, therefore giving you the perf you need, if needed.
You could also say you use write through caching, where writes populate the cache with updated information.

Another huge glaring issue is pagination and their "user feed" system. That home screen, where you load everyone's posts, pages and updates is a critical component of how FB is designed. Figuring that out, and designing something that feeds you almost endless amount of information is a big challenge.

more details on the caching and DB ideas

##################################################################################################

## Design video sharing platform like Youtube

referemce : https://leetcode.com/discuss/interview-question/system-design/496042/Design-video-sharing-platform-like-Youtube

Gathering requirements

The problem description is intended to be ambigious as the interviewer wants to check if we're able to ask reasonable questions, collect requirements and define a core set of features for a minimum viable product (MVP) that we can start to work with.

In this case, I'd like to ask a few questions to make things clear, including

    Q: What are main features of the video sharing platform?
        A: The system will be a public platform that users can watch and upload videos.
    Q: Who will be the users of the system?
        A: Users will be around the world.
    Q: How are they going to use it?
        A: Users will use various kinds of devices to visit our service.
    Q: Is there any external dependencies? What are the upstream and downstream system?
        A: The system will leverage existing authentication system.

Once I get answers for above questions, I'd confirm with the interviewer that I'll design a video platform that enables users to watch and upload videos. Authentication is out of the scope of this problem.

Based on information that I gathered so far, I come up with a bunch of functional and non-functional requirements below and confirm with interviewer.

Functional requirements

    Users can watch videos on the platform
    Users can upload their own videos

Non-functional requirements

    The platform should be highly available
    The response time for users in different regions should be at the same level
    The platform should scale while userbase is increasing

Estimation

The goal of this step is to come up with estimated numbers of how scalable our system should be.

We have two types of requests, read and write. Write request(upload videos) will take much longer time and is ususally much less than read requests (recall how often you watch videos on Youtue and the times you upload videos).

So, let's focus on read request firstly. As an easy start, assume our service receives and completes 1000 request per second (RPS). I use request to reflect common server requirements rather than functionality specific requirements eg. Tweets, Views ... because it's business independent. Functionality specific requirements will be eventually mapped to server requirements anyway.

For one day, we'll have 1000 * 24 * 60 * 60 ~= 1000 * 30 * 3000 = 90 million = 90 M requests
For one year, we'll hvae 90M * 12 * 30 = 90 M * 360 ~= 100 M * 300 = 30 billion = 30 B requests
For five years, we'll have 30B * 5 = 150 billion = 150 B requests in total.

The next assumption I'm going to make is the response time. Assume our response time SLA is 200ms.

Then I need to have 1000 / (1s / 200ms) = 200 threads in total to handle 1000 RPS. So, the next question will be how many servers do I need to have 200 threads. One simple formula for estimating ideal Java thread pool size is

Number of threads = Number of Available Cores * Target CPU utilization * (1 + Wait time / Service time)

    Waiting time - is the time spent waiting for IO bound tasks to complete, say waiting for HTTP response from remote service.
    Service time - is the time spent being busy, say processing the HTTP response, marshaling/unmarshaling, etc.

Because our video sharing web service is not computing-intensive application(though it can be, considering video encoding, compression), I assume the Wait time / Service time ratio will be relatively large, say 50. And also assume our server has 2 CPU cores running at 50% utilization.

Then, each of this kind of server can support 2 * 0.5 * (1 + 50) ~= 50 threads and since we need to have 200 threads to handle 1000 RPS, so we need 200 / 50 = 4 servers to handle 1000 RPS.

Let's switch to write requests (upload video). Assume the read / write or say watch / upload ratio is 100. So, we're expecting 1000 / 100 = 10 write requests per second. Please note that the uploading time varies because the video size and network speed play important roles here. So, the estimate is even more subjective.

Assume average video size is 500 MB and network bandwidth on customer side is 100 mbps. Then,

    each video would take 500 MB / (100 mbps / 8) = 40 seconds to upload
    since we have 10 upload request per second, we have 40 * 10 = 400 concurrent uploading, the bandwidth requirement on our side will be 400 * 100 mbps = 40000 mbps
    total memory usage will be 40000 mbps / 8 = 5000 MB = 5GB, if our server has 2GB RAM, then we need to have 3 servers for uploading. However, because we have 400 concurrent uploading, it requires 400 threads to serve. This time the Wait time / Service time ratio is close to 1, and if we still use 2 CPU cores server running at 50% utilization, each server could support 2 * 0.5 * (1+1) = 2 threads. So, we need 400 / 2 = 200 servers for video uploading.

Design Goals

Latency - Is our service latency sensitive (Or in other words, Are requests with high latency and a failing request, equally bad?)
Yes, to provide great customer experience, latency is very important for video service

Consistency - Does our service require tight consistency?
Not really, it's okay if things are eventually consistent.

Availability - Does this problem require 100% availability?
Yes

System interface definition

At this step, I'm designing the APIs that our service exposes to clients. Based on features and requirements I gathered at the first step, the video platform I'm going to design is apparently a web application. The best practice is to decouple the frontend and backend so that the frontend and backend can evolve independently as long as they obey the contract(backend service provides API and clients consume the API).

There are different API design style, SOAP, REST, and graphQL. I'll create a set of RESTful API as it's lightweight compared with SOAP and it's the broadly supported and the most popular one among developers.

Designing RESTful API requires us to first identity resources and then map HTTP methods to operations.

Apparently, we have at least two resources, video and user.

Our service supports operations including upload video, play video, create user, get user info. So, we can have following APIs.

Upload video API

POST  /v1/videos
		Request header
			Content-Type: multipart/form-data
		Request body
			userID
			videoTitle
			videoDescription
			language
			videoFile binary data
		Response body
			videoProcessingJobID

The upload API uses HTTP POST method and v1/videos endpoint to upload a video file with videoTitle, videoDescription...... metadata passed in the request body. Wheter adding API versioning like "v1" in the API is still controversal but I think it'll help us evolve APIs freely. So, I use it in my design.

Using HTTP POST to upload a bianry file is not as simple as we expect. The Content-Type has to be multipart/form-data and the video file binary data will be included between boundary parameters. I'm not going to cover technical details at here. And also, we can even split the big video file and upload chunks in parallel. Again, that's implementation details.

Please note that the response of video uploading request will return a videoProcessingJobID that clients can use to check processing status. The reason is that once video is uploaded to our service, we'll do a series of time-consuming operations like deduplication, compression and create copies with different resolutions, etc.. I'd like to do them in an asynchronous way to provide a good customer experience. Client can polling with the videoProcessingJobID to check the progress later on.

The watch API is also straight forward and it's like

GET /v1/videos/<videoID>
		Request header
			access_token
		Response body
			videoURL

As we learned earlier, authentication and authorization is out of the scope of this problem. I simply add the access_token to the request header. Idealy, once the user is done authentication during login, an id_token or access_token (depends on the OIDC flow that the authentication flow is using) would be issued to the user and it'll be passed to backend, decoded and validated there.

At here, I just ignore the access control part for videos. In reality, the returned videoURL has to be either short lived or has some authorzation mechanism to prevent undesired access.

Next is the user creation and fetching user info API

POST /v1/users
	Request body
		userName
		region
		age
	Response body
		userID

GET /v1/users/<userID>
	Request header
		access_token
	Response body
		userID
		userName
		region
		age

Data Model

After APIs are ready, let's talk about data model. We have two entities, video and user. One user can have multiple videos and one video can only belong to one user.

image

High Level Design

Before we jump into the high level design, we need to have workflows in mind.

    upload video
        user upload video, once the upload is done, create a job and put it into the video post processing queue and return the job id to client for future progress checking
        our service picks up job from the queue and conducts a serise processing, e.g. check duplication, compression
        once post-processign is done, persist video in object storage (e.g. AWS S3 bucket)
        persist video metadata (including video URL in S3 bucket)
    watch video
        user sends request to access a video by videoID
        server return the URL of the requested video

Now, let's consider the database for user info and video metadata. Considering the scalability requirement of our service and relatively simple data model, I'm going to use NoSQL database, more specifically, AWS DynamoDB for our user info and video metadata. Using AWS S3 as the video storage.

Designing schema for NoSQL database is quite different from that of SQL database. In SQL schema, we first identify entites, denormalize them and put into tables. The relation between entities is expressed through foreign keys and the query flexibility is provided by SQL query language.

For NoSQL database, especially DynamoDB, we first identify access patterns. And then, design database schema and denormalize data if it's necessary. DynamoDB provides excellent scalability at the the cost of less access flexibility. DynamoDB recommends putting all entites into one table with carefully designed partition key and optional sort key. In case we want to support new access pattern in future, we can add GSI (Global Secondary Index) to DynamoDB, we do have flexibility to some extent.

The access patterns we'll support are

    given a videoID, access the video
    given a userID, access the user info
    given a userID, access all videos that are uploaded by the user

So, I design the DynamoDB schema as below

   *Entity*                              *Partition Key*             *Sort Key*
	Video                                #VIDEO#<VideoID>         #METADATA#<VideoID>
	User                                 #USER#<UserID>           #METADATA#<UserID> 
	UserVideoMapping                     #USER#<VideoID>         #VIDEO#<VideoID>

The #USER and #VIDEO are like name space that avoid to have collisons between entities.

Recall that we have to use at least 4 servers to support 1000 RPS, the high level design is like below

image

Detailed Design

How to scale the architecture? Ideally, before making any decisions about scaling, we should first do performance tests against our system, monitor CPU and memory usage and latency and find the bottleneck. At here, I just assume our services will be running into common problems as other data intensive application scales.

Servers and database are usually bottlenecks while visitors are increasing. Cahce can significantly reduce the presessure to servers and databases; hence, improve the scalability

    use CDN (AWS Cloudfront) to serve static resources, including videos, video thumbnails ...
    use cache (AWS DAX) for user info and video metadata access

Besides that, since I'm using DynamoDB, a managed service, as the database storage, it does all the heavy lifting for us, e.g. master-slave replication, multi-master writes, etc.. All we need to do is to setup proper auto scale settings.

The next part we want to change is the "Instances" in the above diagram. Our service is now a monolithic service, all functions are coupled together. Even though, we have multiple instances running, each functions can't scale individually. For example, the video deduplication and video compression are apparently computing intensive and require hardware with powerful CPU while the web serving part could be potentially memory intensive as it needs more RAM to serve incoming requests.

The solution is to break monolithic service into micro-services. Micro-services expose APIs to outside and they use APIs to communicate with others. As the number of services and hence, APIs increased, it's impossbile to ask clients to call each fine-grained APIs directly and we actually only want to expose stable coarse-grained APIs to clients so that client applications don't need to update their code frequently. To solve this problem, we introduce API gateway into our system. API gateway will encapsulate fine-grained APIs provided by each micro-services and provide APIs to clients.

image

Please note that I only drew two micro-services above; it's over-simplified. In reality, it'll definitely have more services and orchestrators that aggregate responses from subsets of micro-services. Anyway, it at least shows the basic idea that each micro-service can scale independently.

Summary

I just write up a skeleton of the design. There can be numerous details to dive deep, like

    Add more features
        how to add view count to a video
        how to add user interaction, "Like", "+1", to a video,
        how to follow a user
    System implementation details, with and without leveraging AWS
        load balancing strategy, health check, service high availability
        database sharding, fault tolerance
        large volume of uploading requests, how to queueing them


Here, is a hosted demo on AWS: https://flexoriginals.ml/app/@home and GitHub repo: and https://github.com/anu1601cs/flex-originals

https://gist.github.com/Anu1601CS/288c51d8edd7c0743a73b7fa4d59fcf2


    Have you thought about memory requirement? Scaling the memory? Cost also plays an improtant role.
    How many years would you save a particular video?
    Which mechanism will you use to delete a particular video? (This also involves finding the video in the servers)
    Laslty, If a user wants to expose the video to particular set of members, how would you evovle your system?




###################################

## design youtube

https://leetcode.com/discuss/interview-question/system-design/733520/Design-YouTube-Very-detailed-design-with-diagrams

Videos are streamed from CDN directly. The edge server closest to you will deliver the video. Thus, there is very little latency. Figure 14-7 shows a high level of design for video streaming.
image

Step 3 - Design deep dive
In the high-level design, the entire system is broken down in two parts: video uploading flow and video streaming flow. In this section, we will refine both flows with important optimizations and introduce error handling mechanisms.

Video transcoding
When you record a video, the device (usually a phone or camera) gives the video file a certain format. If you want the video to be played smoothly on other devices, the video must be encoded into compatible bitrates and formats. Bitrate is the rate at which bits are processed over time. A higher bitrate generally means higher video quality. High bitrate streams need more processing power and fast internet speed.
Video transcoding is important for the following reasons:
• Raw video consumes large amounts of storage space. An hour-long high definition video recorded at 60 frames per second can take up a few hundred GB of space.
• Many devices and browsers only support certain types of video formats. Thus, it is important to encode a video to different formats for compatibility reasons.
• To ensure users watch high-quality videos while maintaining smooth playback, it is a good idea to deliver higher resolution video to users who have high network bandwidth and lower resolution video to users who have low bandwidth.
• Network conditions can change, especially on mobile devices. To ensure a video is played continuously, switching video quality automatically or manually based on network conditions is essential for smooth user experience.
Many types of encoding formats are available; however, most of them contain two parts:
• Container: This is like a basket that contains the video file, audio, and metadata. You can tell the container format by the file extension, such as .avi, .mov, or .mp4.
• Codecs: These are compression and decompression algorithms aim to reduce the video size while preserving the video quality. The most used video codecs are H.264, VP9, and HEVC.

Directed acyclic graph (DAG) model
Transcoding a video is computationally expensive and time-consuming. Besides, different content creators may have different video processing requirements. For instance, some content creators require watermarks on top of their videos, some provide thumbnail images themselves, and some upload high definition videos, whereas others do not.

To support different video processing pipelines and maintain high parallelism, it is important to add some level of abstraction and let client programmers define what tasks to execute. For example, Facebook’s streaming video engine uses a directed acyclic graph (DAG) programming model, which defines tasks in stages so they can be executed sequentially or parallelly [8]. In our design, we adopt a similar DAG model to achieve flexibility and parallelism. Figure 14-8 represents a DAG for video transcoding.
image

In Figure 14-8, the original video is split into video, audio, and metadata. Here are some of the tasks that can be applied on a video file:
• Inspection: Make sure videos have good quality and are not malformed.
• Video encodings: Videos are converted to support different resolutions, codec, bitrates, etc. Figure 14-9 shows an example of video encoded files.
• Thumbnail. Thumbnails can either be uploaded by a user or automatically generated by the system.
• Watermark: An image overlay on top of your video contains identifying information about your video.
image

Video transcoding architecture
The proposed video transcoding architecture that leverages the cloud services, is shown in Figure 14-10.
image

The architecture has six main components: preprocessor, DAG scheduler, resource manager, task workers, temporary storage, and encoded video as the output. Let us take a close look at each component.

Preprocessor
image

The preprocessor has 4 responsibilities:

    Video splitting. Video stream is split or further split into smaller Group of Pictures (GOP) alignment. GOP is a group/chunk of frames arranged in a specific order. Each chunk is an independently playable unit, usually a few seconds in length.
    Some old mobile devices or browsers might not support video splitting. Preprocessor split videos by GOP alignment for old clients.
    DAG generation. The processor generates DAG based on configuration files client programmers write. Figure 14-12 is a simplified DAG representation which has 2 nodes and 1 edge:
    image

This DAG representation is generated from the two configuration files below (Figure 14-13):
image

    Cache data. The preprocessor is a cache for segmented videos. For better reliability, the preprocessor stores GOPs and metadata in temporary storage. If video encoding fails, the system could use persisted data for retry operations.

DAG scheduler
image

The DAG scheduler splits a DAG graph into stages of tasks and puts them in the task queue in the resource manager. Figure 14-15 shows an example of how the DAG scheduler works.
image

As shown in Figure 14-15, the original video is split into three stages: Stage 1: video, audio, and metadata. The video file is further split into two tasks in stage 2: video encoding and thumbnail. The audio file requires audio encoding as part of the stage 2 tasks.

Resource manager
image

The resource manager is responsible for managing the efficiency of resource allocation. It contains 3 queues and a task scheduler as shown in Figure 14-17.
• Task queue: It is a priority queue that contains tasks to be executed.
• Worker queue: It is a priority queue that contains worker utilization info.
• Running queue: It contains info about the currently running tasks and workers running the tasks.
• Task scheduler: It picks the optimal task/worker, and instructs the chosen task worker to execute the job.
image

The resource manager works as follows:
•The task scheduler gets the highest priority task from the task queue.
•The task scheduler gets the optimal task worker to run the task from the worker queue.
•The task scheduler instructs the chosen task worker to run the task.
•The task scheduler binds the task/worker info and puts it in the running queue.
•The task scheduler removes the job from the running queue once the job is done.

Task workers
image

Task workers run the tasks which are defined in the DAG. Different task workers may run different tasks as shown in Figure 14-19.
image

Temporary storage
image

Multiple storage systems are used here. The choice of storage system depends on factors like data type, data size, access frequency, data life span, etc. For instance, metadata is frequently accessed by workers, and the data size is usually small. Thus, caching metadata in memory is a good idea. For video or audio data, we put them in blob storage. Data in temporary storage is freed up once the corresponding video processing is complete.

Encoded video
image

Encoded video is the final output of the encoding pipeline. Here is an example of the output: funny_720p.mp4. System optimizations At this point, you ought to have good understanding about the video uploading flow, video streaming flow and video transcoding. Next, we will refine the system with optimizations, including speed, safety, and cost-saving.

Speed optimization: parallelize video uploading
Uploading a video as a whole unit is inefficient. We can split a video into smaller chunks by GOP alignment as shown in Figure 14-22.
image

This allows fast resumable uploads when the previous upload failed. The job of splitting a video file by GOP can be implemented by the client to improve the upload speed as shown in Figure 14-23.
image

Speed optimization: place upload centers close to users
Another way to improve the upload speed is by setting up multiple upload centers across the globe (Figure 14-24). People in the United States can upload videos to the North America upload center, and people in China can upload videos to the Asian upload center. To achieve this, we use CDN as upload centers.
image

Speed optimization: parallelism everywhere
Achieving low latency requires serious efforts. Another optimization is to build a loosely coupled system and enable high parallelism. Our design needs some modifications to achieve high parallelism. Let us zoom in to the flow of how a video is transferred from original storage to the CDN. The flow is shown in Figure 14-25, revealing that the output depends on the input of the previous step. This dependency makes parallelism difficult.
image

To make the system more loosely coupled, we introduced message queues as shown in Figure 14-26. Let us use an example to explain how message queues make the system more loosely coupled.
• Before the message queue is introduced, the encoding module must wait for the output of the download module.
• After the message queue is introduced, the encoding module does not need to wait for the output of the download module anymore. If there are events in the message queue, the encoding module can execute those jobs in parallel.
image

Safety optimization: pre-signed upload URL
Safety is one of the most important aspects of any product. To ensure only authorized users upload videos to the right location, we introduce pre-signed URLs as shown in Figure 14-27.
image

The upload flow is updated as follows:

    The client makes a HTTP request to API servers to fetch the pre-signed URL, which gives the access permission to the object identified in the URL. The term pre-signed URL is used by uploading files to Amazon S3. Other cloud service providers might use a different name. For instance, Microsoft Azure blob storage supports the same feature, but call it “Shared Access Signature” [10].
    API servers respond with a pre-signed URL.
    Once the client receives the response, it uploads the video using the pre-signed URL.

Safety optimization: protect your videos
Many content makers are reluctant to post videos online because they fear their original videos will be stolen. To protect copyrighted videos, we can adopt one of the following three safety options:
• Digital rights management (DRM) systems: Three major DRM systems are Apple FairPlay, Google Widevine, and Microsoft PlayReady.
• AES encryption: You can encrypt a video and configure an authorization policy. The encrypted video will be decrypted upon playback. This ensures that only authorized users can watch an encrypted video.
• Visual watermarking: This is an image overlay on top of your video that contains identifying information for your video. It can be your company logo or company name.

Cost-saving optimization
CDN is a crucial component of our system. It ensures fast video delivery on a global scale. However, from the back of the envelope calculation, we know CDN is expensive, especially when the data size is large. How can we reduce the cost?
Previous research shows that YouTube video streams follow long-tail distribution [11] [12]. It means a few popular videos are accessed frequently but many others have few or no viewers. Based on this observation, we implement a few optimizations:

    Only serve the most popular videos from CDN and other videos from our high capacity storage video servers (Figure 14-28).
    image

    For less popular content, we may not need to store many encoded video versions. Short videos can be encoded on-demand.

    Some videos are popular only in certain regions. There is no need to distribute these videos to other regions.

    Build your own CDN like Netflix and partner with Internet Service Providers (ISPs). Building your CDN is a giant project; however, this could make sense for large streaming companies. An ISP can be Comcast, AT&T, Verizon, or other internet providers. ISPs are located all around the world and are close to users. By partnering with ISPs, you can improve the viewing experience and reduce the bandwidth charges.

All those optimizations are based on content popularity, user access pattern, video size, etc. It is important to analyze historical viewing patterns before doing any optimization. Here are some of the interesting articles on this topic: [12] [13].

Error handling
For a large-scale system, system errors are unavoidable. To build a highly fault-tolerant system, we must handle errors gracefully and recover from them fast. Two types of errors exist:
• Recoverable error. For recoverable errors such as video segment fails to transcode, the general idea is to retry the operation a few times. If the task continues to fail and the system believes it is not recoverable, it returns a proper error code to the client.
• Non-recoverable error. For non-recoverable errors such as malformed video format, the system stops the running tasks associated with the video and returns the proper error code to the client.

Typical errors for each system component are covered by the following playbook:
• Upload error: retry a few times.
• Split video error: if older versions of clients cannot split videos by GOP alignment, the entire video is passed to the server. The job of splitting videos is done on the server-side.
• Transcoding error: retry
• Preprocessor error: regenerate DAG diagram
• DAG scheduler error: reschedule a task
• Resource manager queue down: use a replica
• Task worker down: retry the task on a new worker
• API server down: API servers are stateless so requests will be directed to a different API server.
• Metadata cache server down: data is replicated multiple times. If one node goes down, you can still access other nodes to fetch data. We can bring up a new cache server to replace the dead one.
• Metadata DB server down:
• Master is down. If the master is down, promote one of the slaves to act as the new master.
• Slave is down. If a slave goes down, you can use another slave for reads and bring up another database server to replace the dead one.

Step 4 - Wrap up
In this chapter, we presented the architecture design for video streaming services like YouTube. If there is extra time at the end of the interview, here are a few additional points:
• Scale the API tier: Because API servers are stateless, it is easy to scale API tier horizontally.
• Scale the database: You can talk about database replication and sharding.
• Live streaming: It refers to the process of how a video is recorded and broadcasted in real time. Although our system is not designed specifically for live streaming, live streaming and non-live streaming have some similarities: both require uploading, encoding, and streaming. The notable differences are:
• Live streaming has a higher latency requirement, so it might need a different streaming protocol.
• Live streaming has a lower requirement for parallelism because small chunks of data are already processed in real-time.
• Live streaming requires different sets of error handling. Any error handling that takes too much time is not acceptable.
• Video takedowns: Videos that violate copyrights, pornography, or other illegal acts shall be removed. Some can be discovered by the system during the upload process, while others might be discovered through user flagging.

Congratulations on getting this far! Now give yourself a pat on the back. Good job!

Reference materials
[1] YouTube by the numbers: https://www.omnicoreagency.com/youtube-statistics/
[2] 2019 YouTube Demographics: https://blog.hubspot.com/marketing/youtube-demographics
[3] Cloudfront Pricing: https://aws.amazon.com/cloudfront/pricing/
[4] Netflix on AWS: https://aws.amazon.com/solutions/case-studies/netflix/
[5] Akamai homepage: https://www.akamai.com/
[6] Binary large object: https://en.wikipedia.org/wiki/Binary_large_object
[7] Here’s What You Need to Know About Streaming Protocols: https://www.dacast.com/blog/streaming-protocols/
[8] SVE: Distributed Video Processing at Facebook Scale: https://www.cs.princeton.edu/~wlloyd/papers/sve-sosp17.pdf
[9] Weibo video processing architecture (in Chinese): https://www.upyun.com/opentalk/399.html
[10] Delegate access with a shared access signature: https://docs.microsoft.com/en-us/rest/api/storageservices/delegate-access-with-shared-access-signature
[11] YouTube scalability talk by early YouTube employee: https://tinyurl.com/jlbbpo6
[12] Understanding the characteristics of internet short video sharing: A youtube-based measurement study. https://arxiv.org/pdf/0707.3670.pdf
[13] Content Popularity for Open Connect: https://netflixtechblog.com/content-popularity-for-open-connect-b86d56f613b

Link to the course: https://courses.systeminterview.com
Four sample chapters: http://www.systeminterview.com/
