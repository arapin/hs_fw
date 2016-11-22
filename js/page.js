function goPage(method){
	switch (method)
	{
		case "index" : location.href = "/"; break;
		case "join" : location.href = "?com=user&lnd=join"; break;
		case "modify" : location.href = "?com=user&lnd=modify"; break;
		case "login" : location.href = "?com=user&lnd=login"; break;
		case "logout" : location.href = "?com=user&pro=logout"; break;
		case "map" : location.href = "?com=shaman&lnd=map"; break;
		case "shamanJoin" : location.href = "?com=shaman&lnd=join"; break;
		case "shamanLogin" : location.href = "?com=shaman&lnd=login"; break;
		case "shModify" : location.href = "?com=shaman&lnd=modify"; break;
		case "shLogout" : location.href = "?com=shaman&pro=logout"; break;
	}
}