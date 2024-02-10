
<h1 align="center">HereWeGo-MapAPI-Study</h1>

![alt text](https://upload.wikimedia.org/wikipedia/commons/thumb/c/c7/HERE_logo.svg/1200px-HERE_logo.svg.png)


Este repositório é dedicado ao estudo da API de mapas Here We Go. Para começar, você precisará gerar uma API Key no site da Here We Go. Você pode fazer isso seguindo as instruções em [Gerar uma API Key](https://www.here.com/docs/bundle/identity-and-access-management-developer-guide/page/topics/dev-apikey.html).

Depois de obter sua chave de API, execute o seguinte comando no terminal:

```bash
echo "const API_KEY = 'SUA_CHAVE_DE_API';" > apikey.js
```

Substitua {SUA_CHAVE_DE_API} pela chave que você gerou. Este comando criará um arquivo apikey.js no qual sua chave de API será armazenada para uso no código.