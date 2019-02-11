Obrigado por chegar até aqui, agora chegou a hora de mostrar seus conhecimentos em php e laravel. Fique a vontade
para utilizar a documentação, google, stack overflow, etc. Afinal no dia a dia é assim que trabalhamos...

Você tem 3 horas para executar a tarefa abaixo, caso não consiga terminar não se preocupe, avaliaremos o que conseguiu fazer. Ao final do tempo, por favor faça o commit no repositório enviado. Caso tenha dúvidas quanto a tarefa, faça da forma que achar melhor, se quiser pode deixar comentários nos código.

Boa Sorte!!!
  

## Utilizando Laravel, crie um sistema que permita a visualização, cadastro, edição e exclusão de PNEUS.

### A entidade PNEU tem os seguintes atributos:

marca, modelo, raio, largura,# perfil



### A entidade MARCA tem os seguintes atributos:

nome, imagem



### A entidade MODELO tem os seguintes atributos:

marca, nome


## Atenção

* No formulário de cadastro de Pneus o carregamento de modelos deve ser dinâmico (AJAX) pela marca escolhida.
* Todos os campos devem ser obrigatórios
* O sistema deve ser acessível apenas a usuários autenticados
* Não pode existir mais de uma marca com o mesmo nome
* Não pode existir mais de um modelo com o mesmo nome
* Ao excluir um pneu o mesmo deve permanecer no banco (não sendo mais exibido na tela de listagem de pneus)
* Largura e perfil são campos numéricos, de 100 a 200 e de 10 a 80 respectivamente 
* Na tela de listagem de pneus os registros devem ser paginados de 10 em 10