function FindProxyForURL(url, host) {

    var d = "DIRECT";
    //var proxy1 = "PROXY 192.168.0.253:9002";
    //var proxy1 = "PROXY 192.168.1.41:9002";
    //var proxy1 = "SOCKS5 192.168.1.41:9003";
    //var proxy2 = "SOCKS5 192.168.1.41:9004";
    //var proxy1 = "PROXY 192.168.0.49:9002";
    //var proxy1 = "PROXY 192.168.1.148:9002";

    //var proxy1 = "SOCKS5 192.168.1.49:55553";
    //var proxy2 = "SOCKS5 192.168.1.41:55553";
    //var proxy3 = "SOCKS5 192.168.1.42:9003";

    var proxy1 = "SOCKS5 192.168.1.41:55551";//web
    var proxy2 = "SOCKS5 192.168.1.41:55552";//cmsticket

	if (
        dnsDomainIs(host, '.i9i8.com')
        || dnsDomainIs(host,"git.opvalue.com")
        || dnsDomainIs(host, '.coolman.com.cn')
        || dnsDomainIs(host, '.pupugao.com')
        || dnsDomainIs(host, '.aaasea.com')
        || dnsDomainIs(host, 'dev.jjshouse.com')
        || dnsDomainIs(host, 'dev.lalamira.com')
        || dnsDomainIs(host, 'dev.invitationsknot.com')
        || dnsDomainIs(host, 'dev.jenjenhouse.com')
        || dnsDomainIs(host, 'dev.jennyjoseph.com')
        || dnsDomainIs(host, 'dev.amormoda.com')
        || dnsDomainIs(host, 'dev.faucetland.com')
        || dnsDomainIs(host, 'dev.vbridal.com')
        || dnsDomainIs(host, 'dev.dressfirst.com')
        || dnsDomainIs(host, 'dev.dressdepot.com')
        || dnsDomainIs(host, 'dev.azazie.com')
        || dnsDomainIs(host, 'devm.azazie.com')
        || dnsDomainIs(host, 'test.jjshouse.com')
        || dnsDomainIs(host, 'devm.jjshouse.com')
        || dnsDomainIs(host, 'devm.jenjenhouse.com')
        || dnsDomainIs(host, 'devm.dressfirst.com')
        || dnsDomainIs(host, 'dev-ticket.jjshouse.com')
        || dnsDomainIs(host, 'dev-ticket.jenjenhouse.com')
        || dnsDomainIs(host, 'dev-blog.jjshouse.com')
        || dnsDomainIs(host, 'localhost')
        || dnsDomainIs(host, '127.0.0.1')
    ) {
        return d;
    } else if (
        dnsDomainIs(host,".lightinthebox.com")
        || dnsDomainIs(host,".jjshouse.com")
        || dnsDomainIs(host,".jenjenhouse.com")
        || dnsDomainIs(host,".jennyjoseph.com")
        || dnsDomainIs(host,".amormoda.com")
        || dnsDomainIs(host,".dressfirst.com")
        || dnsDomainIs(host,".dressdepot.com")
        || dnsDomainIs(host,".vbridal.com")
        || dnsDomainIs(host,".orderfromchina.com")
        || dnsDomainIs(host,".faucetland.com")
        || dnsDomainIs(host,".resellerratings.com")
        || dnsDomainIs(host,".wholesale-dress.com")
        || dnsDomainIs(host,".wholesaledress.com")
        || dnsDomainIs(host,".chiffon-bridesmaid-dresses.com")
        || dnsDomainIs(host,".cheap-bridesmaid-dress.com")
        || dnsDomainIs(host,".weddingdressreview.com")
        || dnsDomainIs(host,".reviewcentre.com")
        || dnsDomainIs(host,".cloudfront.net")
        || dnsDomainIs(host,".tidebuy.com")
        || dnsDomainIs(host,".tbdress.com")
        || dnsDomainIs(host,".dressbraw.com")
        || dnsDomainIs(host,"jjshouse.co.uk")
        || dnsDomainIs(host,"jjshouse.no")
        || dnsDomainIs(host,"jjshouse.fr")
        || dnsDomainIs(host,"jjshouse.de")
        || dnsDomainIs(host,"jjshouse.com.au")
        || dnsDomainIs(host,"jjshouse.ch")
        || dnsDomainIs(host,"jjshouse.se")
        || dnsDomainIs(host,"veryvoga.com")
        || dnsDomainIs(host,"veryvoga.fr")
        || dnsDomainIs(host,"opvalue.com")
        || dnsDomainIs(host,"renttherunway.com")
        || dnsDomainIs(host,"haproxy.org")
        || dnsDomainIs(host,"pinterest.com")
        || dnsDomainIs(host,"lalamira.com")
        || dnsDomainIs(host,"lalamira.com.au")
        || host.search("pinterest") >= 0
        || dnsDomainIs(host,".pinimg.com")
        || dnsDomainIs(host,"invitationsknot.com")
        || dnsDomainIs(host, 'azazie.com')
    ) {
        return proxy2;
    } else if (
		host.search("google") >= 0
		|| host.search("gmail") >= 0
		|| dnsDomainIs(host,".gstatic.com")
		|| dnsDomainIs(host,".facebook.net")
		|| dnsDomainIs(host,".facebook.com")
		|| dnsDomainIs(host,"facebook.com")
		|| dnsDomainIs(host,".twitter.com")
		|| dnsDomainIs(host,".skype.com")
		|| dnsDomainIs(host,".youtube.com")
		|| dnsDomainIs(host,".blogspot.")
		|| dnsDomainIs(host,".blogger.com")
        || dnsDomainIs(host,"amazonaws.com")
		|| dnsDomainIs(host,"instagram.com")
		|| dnsDomainIs(host,".tollgroup.com")
        || dnsDomainIs(host,".dhl.com")
        || dnsDomainIs(host,".ytimg.com")
		|| dnsDomainIs(host,".fbcdn.net")
        || dnsDomainIs(host,".jaszcouture.com")
        || dnsDomainIs(host,".macduggal.com")
        || dnsDomainIs(host,".edressit.com")
        || dnsDomainIs(host,".twimg.com")
        || dnsDomainIs(host,".jovani.com")
        || dnsDomainIs(host,".wordpress.com")
        || dnsDomainIs(host,".milanoo.com")
        || dnsDomainIs(host,".lafemmefashion.com")
        || dnsDomainIs(host,".dhvalue.com")
        || dnsDomainIs(host,"bit.ly")
        || dnsDomainIs(host,".newyorkdress.com")
        || dnsDomainIs(host,".jovani.com")
        || dnsDomainIs(host,".lasposa.info")
        || dnsDomainIs(host,".maggiesottero.com")
        || dnsDomainIs(host,".flirtprom.com")
        || dnsDomainIs(host,".behance.net")
        || dnsDomainIs(host,".android.com")
        || dnsDomainIs(host,".archive.org")
        || dnsDomainIs(host,".sourceforge.net")
        || dnsDomainIs(host,".sf.net")
        || dnsDomainIs(host,"t.co")
        || dnsDomainIs(host,"trello.com")
        || dnsDomainIs(host,".ggpht.com")
        || dnsDomainIs(host,".semrush.com")
        || dnsDomainIs(host,".livechatinc.com")
        || dnsDomainIs(host,"golang.org")
        || dnsDomainIs(host,"elliewilde.com")
        || dnsDomainIs(host,"business.trustpilot.com")
        || dnsDomainIs(host,"website.informer.com")
        || dnsDomainIs(host,"dwnews.net")
        || dnsDomainIs(host,"dwnews.com")
        || dnsDomainIs(host,"chinadigitaltimes.net")
        || host.search("tumblr") >= 0
        || host.search("pinterest") >= 0
    ){
        return proxy1;
    }

    return d + "; " + proxy1;
}
