## live_streaming

How Does Live Streaming Works?

This document explains the process of live streaming, including encoding, content delivery networks (CDNs), and the use of various protocols to improve transmission speeds. It also discusses the advantages of live streaming over traditional TV broadcasting, such as the ability to provide live chat, comments, and ads, and the flexibility to watch on different devices.

Points to Note

    Live streaming does not necessarily mean a real-time broadcast (with just milli seconds difference). There might be a delay of a few seconds or even minutes between the actual event and when it's streamed to you.

💡 **Live Broadcast**

Why did delays exist in TV broadcasts before the advent of live streaming technology? Television signals are broadcasted by transmitters, which are essentially large servers that transmit these signals. These signals reach you through different means, such as cables. Later, dish antennas were introduced and these signals began reaching you through satellites.

During a live stream of a match, the streaming is first encoded. A video is a collection of pictures which, when run one after the other, creates the effect of a video. This raw video is quite large in size and cannot be transmitted in its raw form. To reduce the size of the video, we use the technique called encoding. Encoding is a process in which we compress the video by breaking it down into multiple chunks without compromising the quality. There are various codecs used for this encoding method, such as AV1, HEVC, and MPEG. These codecs are used to break the video down without reducing the quality.

When a stream is generated from the camera, it is first encoded. This encoded stream is then sent by the transmitter through cables or satellites and finally reaches you. This is called a live broadcast.

Due to the encoding and transmission of live streaming through cables/satellites, there may be a delay of 15-20 seconds before the video reaches you.

💡 **Live Streaming**

With the advent of live streaming apps, the video is transmitted to us through the internet and fiber optic cables laid under the sea. The video passes through web servers that render it before it reaches us.

Taking Hotstar as an example, it streams to a large number of users around the world. The stream originates from the camera (like it used to be in case of live broadcast) and goes through Hotstar servers before reaching the clients. However, this process is not as simple as it sounds.

To send traffic to clients, the server and client must establish a persistent TCP connection. The need for a persistent connection is because the stream must continue to come in, and creating new connections each time would take more time and make the video not remain live.
To maintain a persistent connection, there are various technologies available, such as web sockets. However, a question arises: are all clients connected to different servers? These servers can be located anywhere across the globe. Thus, if a person in London wants to watch an India-Pakistan match on Hotstar, they cannot contact servers located in India. To solve this issue, we need a Content Delivery Network (CDN). A CDN provides the same content, but from a local location near you. It also caches the content so that you don't have to make a call to the server. When you click "play," you are redirected to the closest CDN server located near you. For Hotstar, the CDN is Akamai, which also provides CDN services to other companies. Therefore, you are connected to one of the CDN servers, and from that server, you can stream the content.

Let's recap what's happening:

Steam is coming from the camera, going through the Hotstar servers, and then to the CDN servers. In the CDN servers, it's being cached, and from there, you can see the video. A lot of things are happening at this time: encoding is happening, decoding is happening on your side, and video chunks are being parsed from the server to the CDN. These chunks are then coming to you, and your player or Hotstar app will organize them and continue providing you with a live video that you can watch.

The next question is, what is the time between all of this? Encoding, decoding, and the various protocols that are used (such as HLS or HTTP live streaming or MPEGDash) have helped improve the transmission speeds of these live streaming videos by a lot. Before these were introduced, the live streaming speed was extremely low, and the difference between the actual streaming and the live video you were seeing could be as long as 60 seconds or a few minutes, which is very large. TV broadcast would definitely be faster than that, but with the advent of these protocols, it's come quite close to the live TV broadcast, but TV broadcast can still be faster than live streaming.

So why have we moved to live streaming? What was the problem with TV broadcast? There are several different features that are provided with these streaming apps. You can do live chat, live comments, get all those likes, and people can insert ads inside the ongoing video. You can also play this anywhere on your phone, TV, or laptop, just by using your mobile network. What if you're traveling and don't have a TV? Live streaming has solved a lot of such problems that TV broadcast couldn't solve.

![image info](.image.png)


💡 **What is RTMP**

RTMP is a TCP-based protocol that is designed to support high-quality, low-latency streaming of video and other data.
RTMP uses a stream-based model for transmitting data, which means that the data is divided into small chunks called "packets" that are transmitted over the internet one after the other. This allows RTMP to support real-time streaming of data, as the packets can be transmitted as they are produced, rather than having to wait for the entire dataset to be generated before it can be transmitted.

💡 **What is Adaptive bitrate streaming?**

Adaptive bitrate streaming is a method of delivering audio and video content over the internet in which the quality of the stream is automatically adjusted based on the viewer's internet connection and device capabilities.
In an adaptive bitrate streaming system, the video or audio content is encoded at multiple
bitrates and resolutions. When a viewer accesses the content, the streaming platform will
determine the viewer's internet connection speed and the capabilities of their device and will select the appropriate bitrate and resolution for the stream. If the viewer's internet connection speed changes during the stream, the platform will automatically adjust the bitrate and resolution of the stream to match the new connection speed.
Adaptive bitrate streaming can help to improve the viewing experience for users by ensuring that the stream is always at the highest quality that their internet connection and device can support. It can also help to reduce buffering and other issues that can arise when the viewer's internet connection is not capable of supporting the selected bitrate and resolution.

💡 **How does H.264 encoding work?**

H.264 is a video compression standard that is commonly used to encode video files for a variety of purposes, including streaming over the internet. H.264 uses a combination of techniques to reduce the size of video files without significantly impacting the quality of the video.
One of the key techniques used by H.264 is known as "interframe compression." This technique involves analyzing the differences between consecutive frames of the video and only storing the information that has changed from one frame to the next. By storing only the differences between frames, H.264 is able to significantly reduce the amount of data that is required to represent the video.
H.264 also uses techniques such as quantization, entropy coding, and motion compensation to further reduce the size of the video data. These techniques involve analyzing the video data and removing redundant or irrelevant information, as well as using advanced mathematical algorithms to represent the data more efficiently.

