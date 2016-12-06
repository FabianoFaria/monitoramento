drop database if exists eficazmonitoramento;

create database eficazmonitoramento;

use eficazmonitoramento;


-- Tabela de Logs
-- Apagar a tabela se existir
drop table if exists tb_log;
-- Criar a tabela
create table tb_log
(
    id integer not null auto_increment primary key,
    log varchar (1024) not null,
    dt_criacao timestamp default current_timestamp
);


-- Tabela de perfil de usuarios
-- Associa um nome de perfil com as permissoes que este
-- Usuario pode ter
create table tb_perfil_acesso
(
    id integer primary key auto_increment not null,
    cadastro smallint not null default 0,
    pesquisa smallint not null default 0,
    vinculo smallint not null default 0,
    configuracao smallint not null default 0,
    monitoramento smallint not null default 0,
    editar smallint not null default 0,
    nome varchar (30) not null,
    status_ativo smallint default 0 not null,
    dt_criacao timestamp default current_timestamp not null
);

-- Insere um perfil de acesso
insert into tb_perfil_acesso (nome, status_ativo, cadastro, pesquisa, vinculo, configuracao, monitoramento, editar)
                      values ('Administrador',1,1,1,1,1,1,1);


-- tabela que contem todos os usuario do sistema
create table tb_users
(
    id integer primary key auto_increment not null,
    id_perfil_acesso integer not null,
    nome  varchar     (70)  not null,
    sobrenome varchar (120) not null,
    email varchar     (60)  not null,
    senha varchar     (40)  not null,
    local_usu         smallint default 0 not null, -- verifica se o usuario esta na eficaz ou fora dela
    id_cliente integer,
    tipo_inst smallint default 0 not null,         -- 0 cliente ; 1 filial
    status_ativo      smallint default 1 not null,
    dt_criaco timestamp default current_timestamp,
    foreign key (id_perfil_acesso) references tb_perfil_acesso (id)
); -- fim da tabela de sistema

insert into tb_users (nome, sobrenome,email,senha,local_usu, id_perfil_acesso)
values ("Roberto","Shimokawa","sistemaeficaz@eficazsystem.com.br","3fde6bb0541387e4ebdadf7c2ff31123",1,1),
       ("Leonardo","Hilgemberg","projetos@eficazsystem.com.br","3fde6bb0541387e4ebdadf7c2ff31123",1,1);


-- tabela de estado
create table tb_estado
(
    id integer primary key auto_increment not null,
    nome varchar (30) not null,
    id_user_cad integer not null,
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp
); -- fim da tabela de estado


-- tabela de pais
create table tb_pais
(
    id integer primary key auto_increment not null,
    nome varchar (100) not null,
    id_user_cad integer not null,
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp
);


-- tabela de clientes
create table tb_cliente
(
    id integer primary key auto_increment primary key,
    id_users integer not null,
    id_pais integer not null,
    id_estado integer not null,
    nome varchar (120) not null,
    endereco varchar (220) not null,
    numero int,
    cep numeric (9,0) not null,
    cidade varchar (50) not null,
    bairro varchar (50) not null,
    ddd smallint,
    telefone int,
    foto varchar(300),
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_pais) references tb_pais (id) ,
    foreign key (id_estado) references tb_estado (id) ,
    foreign key (id_users) references tb_users (id)
); -- fim da tabela de clientes


-- tabela de filiais
create table tb_filial
(
    id integer primary key auto_increment not null,
    id_matriz integer not null,
    id_estado integer not null,
    id_pais integer not null,
    id_users integer not null,
    nome varchar (120) not null,
    endereco varchar (220) not null,
    numero int,
    cep numeric (9,0) not null,
    cidade varchar (70) not null,
    bairro varchar (70) not null,
    ddd smallint,
    telefone int,
    foto varchar(300),
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_matriz) references tb_cliente (id) ,
    foreign key (id_pais) references tb_pais (id) ,
    foreign key (id_estado) references tb_estado (id) ,
    foreign key (id_users) references tb_users (id)
); -- fim da tabela de filiais



-- tabela de fabricante
create table tb_fabricante
(
    id integer primary key auto_increment not null,
    id_estado integer not null,
    id_pais integer not null,
    id_users integer not null,
    nome varchar (100) not null,
    ddd smallint,
    telefone int,
    cep numeric (9,0) not null,
    endereco varchar (220) not null,
    numero int,
    cidade varchar (70) not null,
    bairro varchar (70) not null,
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_pais) references tb_pais (id) ,
    foreign key (id_estado) references tb_estado (id) ,
    foreign key (id_users) references tb_users (id)
);


-- tabela de equipamentos
create table tb_equipamento
(
    id integer primary key auto_increment not null,
    id_fabricante integer not null,
    id_users integer not null,
    tipo_equipamento varchar (100) not null,
    modelo varchar (100) not null,
    potencia varchar (15),
    qnt_bateria numeric (5,0),
    caracteristica_equip varchar (45),
    tipo_bateria varchar (20),
    amperagem_bateria varchar (20),
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_fabricante) references tb_fabricante (id) ,
    foreign key (id_users) references tb_users (id)
);


-- tabela de vinculamento
create table tb_sim
(
    num_sim numeric(15,0) primary key not null,
    id_cliente integer,
    id_filial integer,
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_cliente) references tb_cliente (id),
    foreign key (id_filial) references tb_filial (id)
);


-- tabela de relacionamento
create table tb_sim_equipamento
(
    id integer primary key auto_increment not null,
    id_equipamento integer,
    id_sim numeric(15,0) not null,
    num_serie numeric (30,0),
    ambiente varchar (50),
    vinc_tabela smallint default 0 not null,
    status_ativo smallint not null default 1,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_equipamento) references tb_equipamento (id),
    foreign key (id_sim) references tb_sim (num_sim)
);

-- tabela de posicoes
create table tb_posicao
(
    id integer auto_increment primary key not null,
    id_sim_equipamento integer not null,
    id_num_sim numeric (15,0),
    posicao char (1),
    status_ativo smallint default 1,
    dt_criacao timestamp default current_timestamp ,
    foreign key (id_sim_equipamento) references tb_sim_equipamento (id),
    foreign key (id_num_sim) references tb_sim (num_sim)
);



-- tabela de dados
-- apaga tabela
drop table if exists tb_dados;
-- cria tabela
create table tb_dados
(
    id bigint primary key auto_increment not null,
    num_sim numeric (15,0) not null,
    b char (5),
    c char (5),
    d char (5),
    e char (5),
    f char (5),
    g char (5),
    h char (5),
    i char (5),
    j char (5),
    l char (5),
    m char (5),
    n char (5),
    o char (5),
    p char (5),
    q char (5),
    r char (5),
    s char (5),
    t char (5),
    u char (5),
    dt_criacao timestamp default current_timestamp,
    status_ativo smallint default 1,
    foreign key (num_sim) references tb_sim (num_sim)
);


-- tabela de parametros do equipamento relacionado com o sim
create table tb_parametro
(
    id integer auto_increment primary key not null,
    id_equipamento integer,
    id_users integer not null,
    id_sim_equipamento integer,
    num_sim numeric (15,0) not null,
    parametro varchar(400),
    dt_criacao timestamp default current_timestamp,
    status_ativo smallint default 1,
    foreign key (id_equipamento) references tb_equipamento (id),
    foreign key (id_sim_equipamento) references tb_sim_equipamento (id),
    foreign key (id_users) references tb_users (id)
);


-- tabela de mensagem de alerta
-- apaga a tabela se existir
drop table if exists tb_msg_alerta;
-- cria a tabela
create table tb_msg_alerta
(
    id integer auto_increment primary key not null,
    id_users integer not null,
    mensagem varchar (200) not null,
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_users) references tb_users (id)
);


-- tabela de alertas do sistema
-- apaga a tabela se existir
drop table if exists tb_alerta;
-- cria a tabela
create table tb_alerta
(
    id integer auto_increment primary key not null,
    id_sim_equipamento integer not null,
    id_msg_alerta integer not null,
    visto smallint default 0,
    status_ativo smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_sim_equipamento) references tb_sim_equipamento (id),
    foreign key (id_msg_alerta) references tb_msg_alerta (id)
);


-- Tabela de numero de faltas
-- Apaga a tabela caso exista
drop table if exists tb_numero_falta;
-- Cria a tablea
-- num_falta igual a 1 , significa que ocorreu uma nova queda
create table tb_numero_falta
(
    id integer not null auto_increment primary key,
    id_num_sim numeric (15,0) not null,
    num_falta smallint default 1 not null,
    dt_criacao timestamp default current_timestamp,
    foreign key (id_num_sim) references tb_sim (num_sim)
);



-- Grava os valores da mensagem
insert into tb_msg_alerta (mensagem,id_users) values ("Verificar carregador",1) , ("Tens&atilde;o muito baixa",1) ,
("Tens&atilde;o muito alta",1);


-- grava os estados no banco
insert into tb_estado (nome , status_ativo,id_user_cad) values
('Acre',1,1) ,('Alagoas',1,1) , ('Amap&aacute;',1,1) , ('Amazonas',1,1) , ('Bahia',1,1) , ('Cear&aacute;',1,1) , ('Distrito Federal',1,1) ,
('Esp&iacute;rito Santo',1,1) , ('Goi&aacute;s',1,1) , ('Maranh&atilde;o',1,1) , ('Mato Grosso',1,1) , ('Mato Grosso do Sul',1,1) , 
('Minas Gerais',1,1) , ('Par&aacute;',1,1) , ('Para&iacute;ba',1,1) , ('Paran&aacute;',1,1) , ('Pernambuco',1,1) , ('Piau&iacute;',1,1) ,
('Rio de Janeiro',1,1) , ('Rio Grande do Norte',1,1) , ('Rio Grande do Sul',1,1) , ('Rond&ocirc;nia',1,1) , ('Roraima',1,1) , 
('Santa Catarina',1,1) , ('S&atilde;o Paulo',1,1) , ('Sergipe',1,1) , ('Tocantins',1,1) ;


-- insere os paises na base de dados
insert into tb_pais (id_user_cad, status_ativo, nome) value 
(1,1,'Afeganist&atilde;o'),(1,1,'&Aacute;frica do Sul'),(1,1,'Akrotiri'),(1,1,'Alb&acirc;nia'),(1,1,'Alemanha'),(1,1,'Andorra'),
(1,1,'Angola'),(1,1,'Anguila'),(1,1,'Ant&aacute;rctida'),(1,1,'Ant&iacute;gua e Barbuda'),(1,1,'Antilhas Neerlandesas'),
(1,1,'Ar&aacute;bia Saudita'),(1,1,'Arctic Ocean'),(1,1,'Arg&eacute;lia'),(1,1,'Argentina'),(1,1,'Arm&eacute;nia'),(1,1,'Aruba'),
(1,1,'Ashmore and Cartier Islands'),(1,1,'Atlantic Ocean'),(1,1,'Austr&aacute;lia'),(1,1,'&Aacute;ustria'),(1,1,'Azerbaij&atilde;o'),
(1,1,'Baamas'),(1,1,'Bangladeche'),(1,1,'Barbados'),(1,1,'Bar&eacute;m'),(1,1,'B&eacute;lgica'),(1,1,'Belize'),(1,1,'Benim'),
(1,1,'Bermudas'),(1,1,'Bielorr&uacute;ssia'),(1,1,'Birm&acirc;nia'),(1,1,'Bol&iacute;via'),(1,1,'B&oacute;snia e Herzegovina'),
(1,1,'Botsuana'),(1,1,'Brasil'),(1,1,'Brunei'),(1,1,'Bulg&aacute;ria'),(1,1,'Burquina Faso'),(1,1,'Bur&uacute;ndi'),(1,1,'But&atilde;o'),
(1,1,'Cabo Verde'),(1,1,'Camar&otilde;es'),(1,1,'Camboja'),(1,1,'Canad&aacute;'),(1,1,'Catar'),(1,1,'Cazaquist&atilde;o'),(1,1,'Chade'),
(1,1,'Chile'),(1,1,'China'),(1,1,'Chipre'),(1,1,'Clipperton Island'),(1,1,'Col&ocirc;mbia'),(1,1,'Comores'),(1,1,'Congo-Brazzaville'),
(1,1,'Congo-Kinshasa'),(1,1,'Coral Sea Islands'),(1,1,'Coreia do Norte'),(1,1,'Coreia do Sul'),(1,1,'Costa do Marfim'),(1,1,'Costa Rica'),
(1,1,'Cro&aacute;cia'),(1,1,'Cuba'),(1,1,'Dhekelia'),(1,1,'Dinamarca'),(1,1,'Dom&iacute;nica'),(1,1,'Egipto'),
(1,1,'Emiratos &aacute;rabes Unidos'),(1,1,'Equador'),(1,1,'Eritreia'),(1,1,'Eslov&aacute;quia'),(1,1,'Eslov&eacute;nia'),(1,1,'Espanha'),
(1,1,'Estados Unidos'),(1,1,'Est&oacute;nia'),(1,1,'Eti&oacute;pia'),(1,1,'Faro&eacute;'),(1,1,'Fiji'),(1,1,'Filipinas'),
(1,1,'Finl&acirc;ndia'),(1,1,'Fran&ccedil;a'),(1,1,'Gab&atilde;o'),(1,1,'G&acirc;mbia'),(1,1,'Gana'),(1,1,'Gaza Strip'),
(1,1,'Ge&oacute;rgia'),(1,1,'Ge&oacute;rgia do Sul e Sandwich do Sul'),(1,1,'Gibraltar'),(1,1,'Granada'),(1,1,'Gr&eacute;cia'),
(1,1,'Gronel&acirc;ndia'),(1,1,'Guame'),(1,1,'Guatemala'),(1,1,'Guernsey'),(1,1,'Guiana'),(1,1,'Guin&eacute;'),
(1,1,'Guin&eacute; Equatorial'),(1,1,'Guin&eacute;-Bissau'),(1,1,'Haiti'),(1,1,'Honduras'),(1,1,'Hong Kong'),(1,1,'Hungria'),
(1,1,'I&eacute;men'),(1,1,'Ilha Bouvet'),(1,1,'Ilha do Natal'),(1,1,'Ilha Norfolk'),(1,1,'Ilhas Caim&atilde;o'),(1,1,'Ilhas Cook'),
(1,1,'Ilhas dos Cocos'),(1,1,'Ilhas Falkland'),(1,1,'Ilhas Heard e McDonald'),(1,1,'Ilhas Marshall'),(1,1,'Ilhas Salom&atilde;o'),
(1,1,'Ilhas Turcas e Caicos'),(1,1,'Ilhas Virgens Americanas'),(1,1,'Ilhas Virgens Brit&acirc;nicas'),(1,1,'&Iacute;ndia'),
(1,1,'Indian Ocean'),(1,1,'Indon&eacute;sia'),(1,1,'Ir&atilde;o'),(1,1,'Iraque'),(1,1,'Irlanda'),(1,1,'Isl&acirc;ndia'),(1,1,'Israel'),
(1,1,'It&aacute;lia'),(1,1,'Jamaica'),(1,1,'Jan Mayen'),(1,1,'Jap&atilde;o'),(1,1,'Jersey'),(1,1,'Jibuti'),(1,1,'Jord&acirc;nia'),
(1,1,'Kuwait'),(1,1,'Laos'),(1,1,'Lesoto'),(1,1,'Let&oacute;nia'),(1,1,'L&iacute;bano'),(1,1,'Lib&eacute;ria'),(1,1,'L&iacute;bia'),
(1,1,'Listenstaine'),(1,1,'Litu&acirc;nia'),(1,1,'Luxemburgo'),(1,1,'Macau'),(1,1,'Maced&oacute;nia'),(1,1,'Madag&aacute;scar'),
(1,1,'Mal&aacute;sia'),(1,1,'Mal&aacute;vi'),(1,1,'Maldivas'),(1,1,'Mali'),(1,1,'Malta'),(1,1,'Man, Isle of'),(1,1,'Marianas do Norte'),
(1,1,'Marrocos'),(1,1,'Maur&iacute;cia'),(1,1,'Maurit&acirc;nia'),(1,1,'Mayotte'),(1,1,'M&eacute;xico'),(1,1,'Micron&eacute;sia'),
(1,1,'Mo&ccedil;ambique'),(1,1,'Mold&aacute;via'),(1,1,'M&oacute;naco'),(1,1,'Mong&oacute;lia'),(1,1,'Monserrate'),(1,1,'Montenegro'),
(1,1,'Mundo'),(1,1,'Nam&iacute;bia'),(1,1,'Nauru'),(1,1,'Navassa Island'),(1,1,'Nepal'),(1,1,'Nicar&aacute;gua'),(1,1,'N&iacute;ger'),
(1,1,'Nig&eacute;ria'),(1,1,'Niue'),(1,1,'Noruega'),
(1,1,'Nova Caled&oacute;nia'),(1,1,'Nova Zel&acirc;ndia'),(1,1,'Om&atilde;'),(1,1,'Pacific Ocean'),(1,1,'Pa&iacute;ses Baixos'),(1,1,'Palau'),(1,1,'Panam&aacute;'),(1,1,'Papua-Nova Guin&eacute;'),(1,1,'Paquist&atilde;o'),
(1,1,'Paracel Islands'),(1,1,'Paraguai'),(1,1,'Peru'),(1,1,'Pitcairn'),(1,1,'Polin&eacute;sia Francesa'),(1,1,'Pol&oacute;nia'),(1,1,'Porto Rico'),(1,1,'Portugal'),(1,1,'Qu&eacute;nia'),(1,1,'Quirguizist&atilde;o'),
(1,1,'Quirib&aacute;ti'),(1,1,'Reino Unido'),(1,1,'Rep&uacute;blica Centro-Africana'),(1,1,'Rep&uacute;blica Checa'),(1,1,'Rep&uacute;blica Dominicana'),(1,1,'Rom&eacute;nia'),(1,1,'Ruanda'),(1,1,'R&uacute;ssia'),(1,1,'Salvador'),
(1,1,'Samoa'),(1,1,'Samoa Americana'),(1,1,'Santa Helena'),(1,1,'Santa L&uacute;cia'),(1,1,'S&atilde;o Crist&oacute;v&atilde;o e Neves'),(1,1,'S&atilde;o Marinho'),(1,1,'S&atilde;o Pedro e Miquelon'),(1,1,'S&atilde;o Tom&eacute; e Pr&iacute;ncipe'),
(1,1,'S&atilde;o Vicente e Granadinas'),(1,1,'Sara Ocidental'),(1,1,'Seicheles'),(1,1,'Senegal'),(1,1,'Serra Leoa'),(1,1,'S&eacute;rvia'),(1,1,'Singapura'),(1,1,'S&iacute;ria'),(1,1,'Som&aacute;lia'),
(1,1,'Southern Ocean'),(1,1,'Spratly Islands'),(1,1,'Sri Lanca'),(1,1,'Suazil&acirc;ndia'),(1,1,'Sud&atilde;o'),(1,1,'Su&eacute;cia'),(1,1,'Su&iacute;&ccedil;a'),(1,1,'Suriname'),(1,1,'Svalbard e Jan Mayen'),(1,1,'Tail&acirc;ndia'),
(1,1,'Taiwan'),(1,1,'Tajiquist&atilde;o'),(1,1,'Tanz&acirc;nia'),(1,1,'Territ&oacute;rio Brit&acirc;nico do Oceano &iacute;ndico'),(1,1,'Territ&oacute;rios Austrais Franceses'),(1,1,'Timor Leste'),(1,1,'Togo'),(1,1,'Tokelau'),
(1,1,'Tonga'),(1,1,'Trindade e Tobago'),(1,1,'Tun&iacute;sia'),(1,1,'Turquemenist&atilde;o'),(1,1,'Turquia'),(1,1,'Tuvalu'),(1,1,'Ucr&acirc;nia'),(1,1,'Uganda'),(1,1,'Uni&atilde;o Europeia'),(1,1,'Uruguai'),
(1,1,'Usbequist&atilde;o'),(1,1,'Vanuatu'),(1,1,'Vaticano'),(1,1,'Venezuela'),(1,1,'Vietname'),(1,1,'Wake Island'),(1,1,'Wallis e Futuna'),(1,1,'West Bank'),(1,1,'Z&acirc;mbia'),(1,1,'Zimbabu&eacute;');