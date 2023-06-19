## back of envelope calculations

In a system design interview, the chances are high that you will be asked to estimate QPS (Queries per second) and Storage of the system using a back-of-the-envelope estimation.
There are various scales and numbers anyone appearing for System Design Interview should know. Some of the scales are as follows -

Number Scale

| ** Name ** | *Number* | * Number of Zeros|
| :--- | :---: | :---: |
| **1 Hundred** | 100 | 2 zeros |
| **1 Thousand** | 1000 | 3 zeros |
| *1  Million (M)*** | 1_000_000 | 6 zeros |
| *1  Billion (B)*** | 1_000_000_000 | 9 zeros |
| *1 Trillion (T)*** | 1000_000_000_000 | 12 zeros |
| *1 quadTrillion *** | 1000_000_000_000_000 | 15 zeros |


Power of Two's Scale

In a system design interview, the volume of huge data is measured on the power of 2. It gets as low as bits and bytes. A byte is measured as 8 bits. Estimations become easier if we co-relate the below table with the number table and make a rough approximation. The interviewer will expect you to know these scales.

| ** Name ** | *Power* | * Value|
| :--- | :---: | :---: |
| **1 KB ( KiloByte )** | 2^10 | 1024 ~1K |
| **1 MB ( Mega Byte )** | 2^20 | 1048576 ~ 1M |
| *1  GB ( Giga Byte)*** | 2^30 | 1073741824 ~1B |
| *1  TB ( TeraByte )  *** | 2^ 40 | 1099511627776 ~1T |
| *1  PB ( PetaByte) *** | 2^50 | 1125899906842624 ~1 QuadTrillion |

Latency Numbers

In a system design interview, the latency numbers play a vital role in estimations and in having the knowledge, like how much time certain components take to perform certain operations. Below are some of the latency numbers of various operations -

| ** Operation ** | * Time Taken* |
| :--- | :---: |
| ** L1 cache reference ** | .5 ns |
| ** Branch mispredict ** | 5 ns |
| ** L2 cache reference  ** | 7 ns |
| ** Mutex Lock/Unlock ** | 100 ns |
| ** Main Memory refernct ** | 100 ns |
| ** compress 1k byte with zippy ** | 10000 ns = 10 micros second |
| ** send 2k byte over 1Gbps network ** | 2*8* 10^12/10^9 ns = 20,000 ns  = 20 micro second |



| ** Operation ** | *Time taken* |
| :--- | :---: |
| ** Read 1MB sequentail from memory** | 250 micro seconds |
| ** Round trip bw same data center** | 500  micro seconds |
| ** Disk seek ** | 10 mseconds |
| ** Read 1MB sequentail from network** | 10  mseconds |
| ** Read 1MB sequentail from disk ** | 30  mseconds |
| ** send packets california to netherlands** | 150 mseconds |

Availability Numbers

In a system design interview, the High Availability discussion will happen for sure. It is defined as the ability of the system to be operational for a longer period of time. Below are some of the availability numbers you should know -
| *** Availability %** | * Downtime per year* | * Downtime per month* | * Downtime per day * |
| :--- | :---: |:---: |:---: |
|90% (one nine) |36.53 days |73.05 hours | 2.40 hours|
|99% (two nines) | 3.65 days | 7.31 hours | 14.40 mins|
|99.9% (three nines) | 8.77 hours | 43.83 mins | 1.44 mins|
|99.99% (four nines) | 52.60 mins | 4.38 mins | 8.64 secs|
|99.999% (five nines) | 5.26 mins | 26.30 secs | 864.00 millisecs|
|99.9999% (six nines) | 31.56 secs |2.63 secs |86.40 millisecs|
|99.99999% (seven nines) | 3.16 secs |262.98 |8.64 millisecs|
|99.999999% (eight nines)| 315.58 millisecs | 26.30 millisecs | 864.00 microsecs)|
|99.9999999% (nine nines) |31.56 millisecs |2.63 millisecs |86.40 microsecs|


Blob/Object Storage Sizes

In a system design, there are various big systems that involve types of blobs/objects like images, videos, audio, etc. Below are some of the approximate storage sizes of various blobs/objects -

| **Object Type ** | *Size* |
| :--- | :---: |
|char (Unicode) | 2B|
|uuID | 16B|
|Thumbnails | 20-30 KB|
|Website image | 200-300 KB|
|Mobile image | 2-3 MB|
|Documents like books, reports, govt Ids etc | 1-3 MB|
|Audio files like songs, recordings etc | 4-5 MB|
|1 min 720px video | 60 MB|
|1 min 1080px video | 130 MB|
|1 min 4K video|350 MB
