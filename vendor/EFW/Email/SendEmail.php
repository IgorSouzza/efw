<?php

namespace EFW\Email;

class SendEmail
{
	public function send()
	{
		//Variaveis de POST, Alterar somente se necessário 
	    //====================================================
	    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	    //====================================================

	    //REMETENTE --> ESTE EMAIL TEM QUE SER VALIDO DO DOMINIO
	    //==================================================== 
	    $email_remetente = "contato@igorsouzza.com.br"; // deve ser uma conta de email do seu dominio 
	    //====================================================

	    //Configurações do email, ajustar conforme necessidade
	    //==================================================== 
	    $email_destinatario = "contato@igorsouzza.com.br"; // pode ser qualquer email que receberá as mensagens
	    $email_reply = $dados['email']; 
	    $email_assunto = "Contato formmail"; // Este será o assunto da mensagem
	    //====================================================

	    //Monta o Corpo da Mensagem
	    //====================================================
	    $email_conteudo = strip_tags(trim("Nome = {$dados['nome']}")) . "\n"; 
	    $email_conteudo .= strip_tags(trim("Email = {$dados['email']}")) . "\n"; 
	    $email_conteudo .= strip_tags(trim("Whatsapp = {$dados['whatsapp']}")) . "\n"; 
	    $email_conteudo .= strip_tags(trim("Mensagem = {$dados['mensagem']}")) . "\n"; 
	    //====================================================

	    //Seta os Headers (Alterar somente caso necessario) 
	    //==================================================== 
	    $email_headers = implode ( "\n",array ( "From: $email_remetente", "Reply-To: $email_reply", "Return-Path: $email_remetente","MIME-Version: 1.0","X-Priority: 3","Content-Type: text/html; charset=UTF-8" ) );
	    //====================================================

	    //Enviando o email 
	    //==================================================== 
	    if (mail ($email_destinatario, $email_assunto, nl2br($email_conteudo), $email_headers)){ 
	            #echo "</b>E-Mail enviado com sucesso!</b>"; 
	    } 
	    else{ 
	            #echo "</b>Falha no envio do E-Mail!</b>";
	    } 
	    //====================================================
	}
}