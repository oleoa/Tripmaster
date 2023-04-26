# Pap
Uma ferramenta de ajuda aos clientes para organizar e planear as viagens.

## Método
Que usuário cria uma conta, cada conta tem vários planos de viagens.
Cada plano de viagem tem definido um voo de ida e um de volta, pessoas em comum
que vão viajar nessa viagem (possíveis outras contas na aplicação), um hotel ou apartamento
para dormir, um carro de aluguel e pontos turísticos a visitar.
Nada é obrigatório, porém é recomendado que use tudo nessa aplicação para marcar os arrendamentos.
O esquema de horário pode ser definido para organizar todos os dias da viagem, com alugeis de carros e estadias.

## User
Cada usuário tem um id único, um nome, nome completo, data de aniversário
(para saber a idade e portanto os preços e pontos turísticos recomendados),
data de criação da conta, planos de viagens, último plano de viagem editado,
um método de pagamento salvo.

## Planos de viagens
Cada plano de viagem tem um ou mais países de destino,
um voo para a ida e um voo para a volta, 
uma lista de usuários que estarão na viagem,
nenhuma ou mais estadias que vão ficar,
nenhum ou mais carros para aluguel
e uma lisa de atrações que desejam visitar.

## API's
Os países, os voos e as atrações serão importadas por api's.

## Aluguel
As estadias e os carros serão alugadas do próprio site, ficando 15%
do valor combinado para o site.

## Site
A página principal do site estará aberta na última viagem editada pelo user,
se o user não tem nenhuma viagem salva estará na pagina de criação de planos.