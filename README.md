# ProxyScore
Detect potentialy malicious (non ISP) proxies using minimal PHP

This project is meant to do only minimal checking in order to do it quickly. It does not currently use a GEOip database or similar to determine that the proxy is for an ISP, but instead gives a lower score if ipv4 is proxying for a ipv6 address, and a score of 0 for no proxy headers.
