#Teste Proload

##O que foi feito?
* Um CRUD de destinatários (recipients), utilizando o pacote backpack (127.0.0.1/admin/recipient);
* Para o consumo do feed RSS de tempos em tempos foi criado um Schedule através do laravel (em app\Console\Kernel.php no método schedule), esse schedule roda um comando ("process:rss") a cada 2 horas, o comando por sua vez processa o feed RSS do G1 e pega as 3 ultimas noticias, e as envia para todos os destinatarios que possuem o status como ativo, 