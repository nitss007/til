## Show hardware configuration on Unix systems

`inxi` is a convenient tool to display system information in a readable well formatted way. Use the `-F` flag to display all information and optionally `-c 0` in order to turn off colors (because it looked weird on my terminal).

Example:

```bash
inxi -F -c 0
System:    Host: lin-haeuslmannm Kernel: 4.15.0-159-generic x86_64 bits: 64 Desktop: KDE Plasma 5.12.9
           Distro: Ubuntu 18.04.6 LTS
Machine:   Device: laptop System: Dell product: XPS 15 9560 serial: N/A
           Mobo: Dell model: 05FFDN v: A00 serial: N/A UEFI: Dell v: 1.23.1 date: 05/25/2021
Battery    BAT0: charge: 61.4 Wh 100.0% condition: 61.4/97.0 Wh (63%)
           hidpp__0: charge: N/A condition: NA/NA Wh
CPU:       Quad core Intel Core i7-7700HQ (-MT-MCP-) cache: 6144 KB
           clock speeds: max: 3800 MHz 1: 800 MHz 2: 800 MHz 3: 800 MHz 4: 800 MHz 5: 800 MHz 6: 800 MHz
           7: 800 MHz 8: 800 MHz
Graphics:  Card-1: Intel Device 591b
           Card-2: NVIDIA GP107M [GeForce GTX 1050 Mobile]
           Display Server: x11 (X.Org 1.19.6 ) driver: i915
           Resolution: 1920x1080@60.01hz, 1920x1080@60.00hz, 1920x1080@60.00hz
           OpenGL: renderer: Mesa DRI Intel HD Graphics 630 (KBL GT2) version: 4.6 Mesa 20.0.8
Audio:     Card-1 Intel CM238 HD Audio Controller driver: snd_hda_intel Sound: ALSA v: k4.15.0-159-generic
           Card-2 Asahi Kasei Microsystems AK5370 I/F A/D Converter driver: USB Audio
           Card-3 Logitech OrbiCam driver: USB Audio
           Card-4 Realtek driver: USB Audio
Network:   Card-1: Qualcomm Atheros QCA6174 802.11ac Wireless Network Adapter driver: ath10k_pci
           IF: wlp2s0 state: up mac: 9c:b6:d0:e9:ca:77
           Card-2: Atheros
           IF: null-if-id state: N/A speed: N/A duplex: N/A mac: N/A
Drives:    HDD Total Size: 1024.2GB (45.5% used)
           ID-1: /dev/nvme0n1 model: PC300_NVMe_SK_hynix_1TB size: 1024.2GB
Partition: ID-1: / size: 407G used: 378G (98%) fs: ext4 dev: /dev/nvme0n1p8
           ID-2: swap-1 size: 64.00GB used: 0.00GB (0%) fs: swap dev: /dev/nvme0n1p7
RAID:      No RAID devices: /proc/mdstat, md_mod kernel module present
Sensors:   System Temperatures: cpu: 65.5C mobo: N/A
           Fan Speeds (in rpm): cpu: 3678 fan-2: 3713
Info:      Processes: 484 Uptime: 1:53 Memory: 13523.0/32017.9MB Client: Shell (zsh) inxi: 2.3.56
```

