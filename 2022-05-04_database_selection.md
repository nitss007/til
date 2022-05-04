## Database_Selection

Cache
Options: Redis, Memcache
Use: Redis (Redis is an modern version of Memcache). Redis understands data structures like list etc, so performing list append fast in Redis wrt Memcache which sees all values as a blob.

File storage
Why? To store images, videos, files etc. These are blob storages. DBMS is used when we have to query on the data. But file is something we just serve.
Options: S3

Text search engine
Why?
Netflix: search for a movie
Amazon: search for a product
Uber: search for a location
Options: Elastic Search, Solar (build over lucene)
Important: They are search engines, not databases. They give availability and redundancy but no guarantee on data, so data may be lost. Store critical data somewhere else.

Fuzzy text search
Why? User may type wrong spelling. For eg, instead of Airport, may type Ariport.
Options: Elasticsearch, Solar

Timeseries database
Why? For metrics
Options: InfluxDB, OpenTSDB 
Note: These are kind of RDBMS with some customization. In it, user will write always in append-only mode and wont edit old data. Also, queries will be bulk queries on a time range. So, optimized for that.

Data Warehouse/ Big Data
Why? Want to store huge data for analytics. Eg for Amazon, which country giving more revenue, which geography has more transactions, which product sold where most etc.
Options: Hadoop
Note: This is more for offline processing.

RDBMS
Why? When information is structured. And when we need ACID guarantees. For eg, in banking, amount debited but not credited, different account balance for different queries etc
Options: MySQL, PostgreSQL, Oracle

NoSQL (Document DB)
Why? For Amazon, building catalogue. Catalogue can have different type of items with different attributes. Eg, T-shirt, Washing machine, Refrigerator, Milk, Medicine etc. This can be stored as json in RDBMS but NoSQL DBs are designed to handle such kind of queries in a more optimized manner.
Options: MongoDB, CouchBase

NoSQL (Columnar DB)
Why? When data is ever increasing. Eg, Uber drivers keep sending their location data every few minutes. And if drivers keep increasing, data will keep growing exponentially. But queries will be low only on this huge data, like what locations for a given driver id.
Options: Cassandra, Hbase
