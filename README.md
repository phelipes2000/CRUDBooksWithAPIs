# CRUDBooksWithAPI
 Crud com APIs integradas(AWS, Google Books e ViaCep)

 No CRUD Book, ao criar é necessário informar:
    Titulo do livro, Nome do autor, Capa e CEP
A API do Google Books irá retornar as seguintes informações:
    Descrição, Data de Publicção e Quantidade de Páginas do livro.
A API ViaCep, irá retornar as seguintes informações:
    Endereço, Cidade e Estado.
Obs:.Os dados retornados pelas APIs são automaticamente gerados ao criar um novo livro.

E por fim, a API da AWS estará ligada ao CRUD em relação a imagem, que será a capa do livro, em operações como Criar(armazena a imagem), Editar(Remove a imagem antiga que está na AWS e armazena a nova imagem), Excluir(Remove a imagem que está na AWS) e Mostrar(imprime na tela a imagem que está armazenada na AWS).
