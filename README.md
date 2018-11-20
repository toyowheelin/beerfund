# beerfund
PHP page that shows the current funding progress to a goal of filling a beer keg via gridcoin using live exchange rates.

A live working example can be found here [Beerfund](http://beerfund.sudogeeks.com)

GridCoin donations S6v2YyShTd9J9VwL7Ngsd6Kz1ZMsfbWUsi

## Getting Started

We will assume that you have a working webserver that supports PHP.

Simply place the files into a folder that is readable by your server and modify the variables at the top of the index.php to suite your environment.

### Prerequisites

A gridcoin wallet with RPC setup running on a computer accessable by the webserver.

Preferably some kind of steady input of funds into your gridcoin wallet such as from doing research.
 
### Setup of wallet RPC via gridcoinresearch.conf

```
server=1
rpcallowip=<IP Address of Remote System>
rpcport=<Port for RPC Communication>
rpcuser=<A Username for RPC>
rpcpassword=<A GOOD Password for RPC>
```
