use eficazmonitoramento;

-- procedure que retorna o total de cliente
-- que possuem equipamento relacionado

drop procedure if exists proc_relacionamento;

delimiter $$
create procedure proc_relacionamento ()
    begin
        -- deleta as tabelas temporarias se existirem
        drop temporary table if exists tmp_retorno;
        
        -- cria as tabelas temporarias
        create temporary table tmp_retorno (id integer primary key auto_increment not null,
                                            num_sim numeric (15,0), nome varchar (120) , tempo datetime, situacao bit, id_cli integer);
        
        -- insere os valores do select na tabela
        insert into tmp_retorno (num_sim, nome, tempo, situacao, id_cli)
        select s.num_sim , c.nome, s.dt_criacao, s.status_ativo, sq.id
        from tb_sim s
        inner join tb_cliente c on c.id = s.id_cliente
        inner join tb_sim_equipamento sq on sq.id_sim = s.num_sim
        where s.id_cliente is not null;
        
        insert into tmp_retorno (num_sim, nome, tempo, situacao, id_cli)
        select s.num_sim , c.nome, s.dt_criacao, s.status_ativo, sq.id
        from tb_sim s
        inner join tb_filial c on c.id = s.id_filial
        inner join tb_sim_equipamento sq on sq.id_sim = s.num_sim
        where s.id_filial is not null;
        
        -- retorna os valores
        select * from tmp_retorno order by (id);
        
        -- apaga as tabelas temporarias
        drop temporary table if exists tmp_retorno;
        
    end $$
delimiter ;

-- fim da procedure de relacionamento de equipamento
-- -------------------------------------------------






-- procedure que retorna o total de cliente por id e tipo

drop procedure if exists proc_trazclinte;

delimiter $$
create procedure proc_trazclinte
(
    in cliente integer ,
    in tipo bit
)
    begin
        -- deleta as tabelas temporarias se existirem
        drop temporary table if exists tmp_clienteRetorno;
        
        -- cria as tabelas temporarias
        create temporary table tmp_clienteRetorno (id integer primary key auto_increment not null,
                                             sim numeric (15,0) , criacao datetime, situacao smallint, cliente varchar (100), 
                                             equipamento varchar (100) , id_sq integer, id_equip varchar(10), tempo datetime);
        
        if tipo = 0 then
            -- 0 cliente
            -- grava pesquisa *** todas os equipamentos com cliente
            insert into tmp_clienteRetorno (sim, criacao, situacao, cliente, equipamento, id_sq, id_equip, tempo)
            select 
                s.num_sim, s.dt_criacao, s.status_ativo, c.nome, e.nome, se.id , concat(e.id,"-e"), se.dt_criacao
            from tb_sim_equipamento se
            inner join tb_sim s on s.num_sim = se.id_sim
            inner join tb_equipamento e on e.id = se.id_equipamento
            inner join tb_cliente c on c.id = s.id_cliente
            where s.id_cliente is not null and se.id_equipamento is not null and c.id = cliente;
            
        elseif tipo = 1 then
            -- grava pesquisa *** todas os equipamentos com filiais
            insert into tmp_clienteRetorno (sim, criacao, situacao, cliente, equipamento,id_sq, id_equip, tempo)
            select 
                s.num_sim, s.dt_criacao, s.status_ativo, c.nome, e.nome, se.id , concat(e.id,"-e"), se.dt_criacao
            from tb_sim_equipamento se
            inner join tb_sim s on s.num_sim = se.id_sim
            inner join tb_equipamento e on e.id = se.id_equipamento
            inner join tb_filial c on c.id = s.id_filial
            where s.id_filial is not null and se.id_equipamento is not null and c.id = cliente;
            
            
        end if;
        
        
        -- retorna os valores
        select * from tmp_clienteRetorno order by (id);
        
        -- apaga as tabelas temporarias
        drop temporary table if exists tmp_clienteRetorno;
        
    end $$
delimiter ;
-- fim da procedure de relacionamento de equipamento
-- -------------------------------------------------










-- procedure de vinculo de numero SIM com Cliente
-- essa procedure verifica se o numero do SIM ja existe

drop procedure if exists cad_sim_cliente;

delimiter $$
-- cria a procedure
create procedure cad_sim_cliente
    (
        in cliente varchar (120) ,
        in sim numeric (15,0),
        in classe char (1)
    )
    begin
        declare flag bit;   -- variavel que monitora se existe algum valor
        set flag = 0;       -- inicia a variavel flag

        -- verifica se o numero do sim existe
        if (select count(num_sim) from tb_sim where num_sim = sim) > 0 then
            -- caso o numero do sim exista, marca 1 no flag
            set flag = 1;
        end if;
        
        -- verifica se o flag esta ativo
        if flag = 0 then
            -- verifica se a tabela ser inserida eh a de cliente
            if classe = "c" then
                -- insere os valores na tabela usando o id do cliente
                insert into tb_sim (id_cliente,num_sim) values (cliente,sim);
                -- retorna uma resposta
                select "Inserido com sucesso.|verdade" as resposta;
            -- senao verifica se a tabela a ser inserida eh a de filial
            elseif classe = "f" then
                -- insere os valores na tabela usando o id da filial
                insert into tb_sim (id_filial,num_sim) values (cliente,sim);
                -- retorna uma mensagem de sucesso
                select "Inserido com sucesso.|verdade" as resposta;
            -- se na encontrar uma letra correspondente
            else
                -- apresenta o erro
                select "Erro ao inserir, verifique se os dados est&atilde;o corretos.|erro" as resposta;
            end if;
        else
            -- apresenta o erro
            select "N&uacute;mero do SIM j&aacute; est&aacute; cadastrado.|erro" as resposta;
        end if;

    end $$
delimiter ;
-- fim da procedure de vinculo de SIM com Cliente
-- ------------------------------------------------------




-- -----------------------------------------------------------
-- Procedure que traz as notificacoes

-- apaga a procedure se existir
drop procedure if exists busca_notificacao;

delimiter $$

create procedure busca_notificacao ()
begin
    -- apaga a tabela temporaria caso exista
    drop temporary table if exists tmp_notifi;
    -- constroi a tabela temporaria
    create temporary table tmp_notifi ( id integer primary key auto_increment not null, se_id integer,
                                    sim numeric (15,0), nome_equip varchar (100) , tipo varchar (50) , modelo char(1) , dt_criacao datetime);
    
    -- realiza o select das informaçoes
    -- select dos equipamentos
    insert into tmp_notifi (se_id, sim, nome_equip, tipo, modelo, dt_criacao)
    select se.id, se.id_sim as sim, e.nome as nome_equip, "vinculo" as tipo , "e", se.dt_criacao
    from tb_sim_equipamento se 
    inner join tb_equipamento e on e.id = se.id_equipamento
    where se.vinc_tabela = 0 and se.status_ativo = 1 and se.id_equipamento is not null;
    
    -- exibe os resultados dos selects de equipamento
    select * from tmp_notifi order by (dt_criacao) desc;
    
    -- apaga a tabela teporaria
    drop temporary table if exists tmp_notifi;
    
end $$

delimiter ;

-- Fim procedure de notificacao
-- -----------------------------------------------------------