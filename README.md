# beerfund
PHP page that shows the current funding progress to a goal of filling a beer keg via gridcoin using live exchange rates.

GridCoin donations SBbcVxZuk61ziThuoTFmdKxHgTpJtECbBH

##Getting Started

We will assume that you have a working webserver that supports PHP.

Simply place the files into a folder that is readable by your server and modify the variables at the top of the index.php to suite your environment.

###Prerequisites

A gridcoin wallet with RPC setup running on a computer accessable by the webserver.

Preferably some kind of steady input of funds into your gridcoin wallet such as from doing research.
 
###Setup of wallet RPC via gridcoinresearch.conf

server=1
rpcallowip=<IP Address of Remote System>
rpcport=<Port for RPC Communication>
rpcuser=<A Username for RPC>
rpcpassword=<A GOOD Password for RPC>
