<?php
/**
 * @package DTC
 * @version $Id: error_strings.php,v 1.8 2006/05/12 17:02:51 seeb Exp $
 * 
 */



/**
 * new localization for new account
 * @see dtc/client/new_account.php
 * 
 */
/*
NOT VALIDATED $txt_err_payment_not_valid[$lang]
TRANSACTION FINISHED AND APPROVED $txt_err_payment_finish_approved[$lang]
PAYMENT CANCELED $txt_err_payment_cancel[$lang]
PAYMENT FAILED $txt_err_payment_failed[$lang]

"Cannot reselect transaction for id $extapi_pay_id: registration failed!" $txt_err_register_cant_reselect_trans[$lang]
"Cannot reselect user: registration failed!" $txt_err_register_cant_reselect_user[$lang]
"Cannot reselect product: registration failed!" $txt_err_register_cant_reselect_product[$lang]
$txt_err_register_succ[$lang]
*/
global $extapi_pay_id; // bug in my script - seeb



$txt_err_payment_not_valid=array(
	"fr" => "NOT VALIDATED",
	"en" => "NOT VALIDATED",
	"hu" => "NOT VALIDATED",
	"it" => "NOT VALIDATED",
	"nl" => "NOT VALIDATED",
	"ru" => "NOT VALIDATED",
	"de" => "NOT VALIDATED",
	"zh" => "NOT VALIDATED",
	"pl" => "P�ATNO�� NIESPRAWDZONA		",
	"es" => "NOT VALIDATED",
	"pt" => "NOT VALIDATED"
);
$txt_err_payment_finish_approved=array(
	"fr" => "TRANSACTION FINISHED AND APPROVED",
	"en" => "TRANSACTION FINISHED AND APPROVED",
	"hu" => "TRANSACTION FINISHED AND APPROVED",
	"it" => "TRANSACTION FINISHED AND APPROVED",
	"nl" => "TRANSACTION FINISHED AND APPROVED",
	"ru" => "TRANSACTION FINISHED AND APPROVED",
	"de" => "TRANSACTION FINISHED AND APPROVED",
	"zh" => "TRANSACTION FINISHED AND APPROVED",
	"pl" => "TRANZAKCJA ZAKO�CZONA I ZAAKCEPTOWANA",
	"es" => "TRANSACTION FINISHED AND APPROVED",
	"pt" => "TRANSACTION FINISHED AND APPROVED"
);
$txt_err_payment_cancel=array(
	"fr" => "PAYMENT CANCELED",
	"en" => "PAYMENT CANCELED",
	"hu" => "PAYMENT CANCELED",
	"it" => "PAYMENT CANCELED",
	"nl" => "PAYMENT CANCELED",
	"ru" => "PAYMENT CANCELED",
	"de" => "PAYMENT CANCELED",
	"zh" => "PAYMENT CANCELED",
	"pl" => "P�ATNO�� ANULOWANA",
	"es" => "PAYMENT CANCELED",
	"pt" => "PAYMENT CANCELED"
);

$txt_err_payment_failed=array(
	"fr" => "PAYMENT FAILED",
	"en" => "PAYMENT FAILED",
	"hu" => "PAYMENT FAILED",
	"it" => "PAYMENT FAILED",
	"nl" => "PAYMENT FAILED",
	"ru" => "PAYMENT FAILED",
	"de" => "PAYMENT FAILED",
	"zh" => "PAYMENT FAILED",
	"pl" => "P�ATNO�� NIEUDANA",
	"es" => "PAYMENT FAILED",
	"pt" => "PAYMENT FAILED"
);
$txt_err_register_cant_reselect_trans=array(
	"fr" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"en" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"hu" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"it" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"nl" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"ru" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"de" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"zh" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"pl" => "Nie mog� ponownie wybra� transakcji dla ID $extapi_pay_id: Rejestracja nieudana!",
	"es" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!",
	"pt" => "Cannot reselect transaction for id $extapi_pay_id: registration failed!"
);
$txt_err_register_cant_reselect_user=array(
	"fr" => "Cannot reselect user: registration failed!",
	"en" => "Cannot reselect user: registration failed!",
	"hu" => "Cannot reselect user: registration failed!",
	"it" => "Cannot reselect user: registration failed!",
	"nl" => "Cannot reselect user: registration failed!",
	"ru" => "Cannot reselect user: registration failed!",
	"de" => "Cannot reselect user: registration failed!",
	"zh" => "Cannot reselect user: registration failed!",
	"pl" => "Nie mog� ponownie wybra� u�ytkownika: Rejestracja nieudana!",
	"es" => "Cannot reselect user: registration failed!",
	"pt" => "Cannot reselect user: registration failed!"
);
$txt_err_register_cant_reselect_product=array(
	"fr" => "Cannot reselect product: registration failed!",
	"en" => "Cannot reselect product: registration failed!",
	"hu" => "Cannot reselect product: registration failed!",
	"it" => "Cannot reselect product: registration failed!",
	"nl" => "Cannot reselect product: registration failed!",
	"ru" => "Cannot reselect product: registration failed!",
	"de" => "Cannot reselect product: registration failed!",
	"zh" => "Cannot reselect product: registration failed!",
	"pl" => "Nie mog� ponownie wybra� produktu: Rejestracja nieudana!",
	"es" => "Cannot reselect product: registration failed!",
	"pt" => "Cannot reselect product: registration failed!"
);

$txt_err_register_succ=array (
	"fr" => "Registration successfull!",
	"en" => "Registration successfull!",
	"hu" => "Registration successfull!",
	"it" => "Registration successfull!",
	"nl" => "Registration successfull!",
	"ru" => "Registration successfull!",
	"de" => "Registration successfull!",
	"zh" => "Registration successfull!",
	"pl" => "Rejestracja przebieg�a pomy�nie",
	"es" => "Registration successfull!",
	"pt" => "Registration successfull!"
);
/** end new arrays **/
$txt_err_email_format = array(
  "fr" => "Mauvais format du login mail: il doit �tre compos� uniquement de lettre non capitales, de nombre ou du signe \"-\".<br>\n",
  "en" => "Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "hu" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "it" => "Formato del login email errato: dovrebbe essere composto solo da lettere minuscole o numeri o dal simbolo \"-\".<br>\n",
  "nl" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "ru" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "de" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "zh" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "pl" => "B��dny format maila lub loginu: mo�esz u�y� ma�ych liter, cyfr lub znaku \"-\" (minus).<br>\n",
  "es" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n",
  "pt" => "TRANS Incorect mail login format: it should be made only with lowercase letters or numbers or the \"-\" sign.<br>\n");

$txt_err_mailbox_does_not_exists_in_db = array(
  "fr" => "Cette boite au lettre n'existe pas dans la base de donn�e !<br>\n",
  "en" => "Mailbox does no exists in database!<br>\n",
  "hu" => "TRANS Mailbox does no exists in database!<br>\n",
  "it" => "La Mailbox non esiste nel database!<br>\n",
  "nl" => "TRANS Mailbox does no exists in database!<br>\n",
  "ru" => "TRANS Mailbox does no exists in database!<br>\n",
  "de" => "TRANS Mailbox does no exists in database!<br>\n",
  "zh" => "TRANS Mailbox does no exists in database!<br>\n",
  "pl" => "Nie ma takiej skrzynki!<br>\n",
  "es" => "TRANS Mailbox does no exists in database!<br>\n",
  "pt" => "TRANS Mailbox does no exists in database!<br>\n");

$txt_err_email_exists_as_mailinglist = array(
  "fr" => "Cette boite existe d�j� dans la base en tant que liste de publipostage !<br>\n",
  "en" => "Mailbox allready exist in database as a mailing list!<br>\n",
  "hu" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n",
  "it" => "La Mailbox esiste gi� nel database come mailing list!<br>\n",
  "nl" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n",
  "ru" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n",
  "de" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n",
  "zh" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n",
  "pl" => "Taka skrzynka ju� istnieje na liscie mailingowej!<br>\n",
  "es" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n",
  "pt" => "TRANS Mailbox allready exist in database as a mailing list!<br>\n");

$txt_err_password_format = array(
  "fr" => "Les mots de passes doivent �tre fait uniquement de caract�res, de chiffres (a-zA-Z0-9) et doivent faire entre 6 et 16 caract�res.<br>\n",
  "en" => "Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "hu" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "it" => "La password � costituita solo da caratteri standard e numeri (a-zA-Z0-9) e dovrebbe essere di lunghezza compresa fra i 6 e i 16 caratteri.<br>\n",
  "nl" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "ru" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "de" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "zh" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "pl" => "Has�o jest tworzone ze standardowego zestawu znak�w (a-zA-Z0-9) i jego d�ugo�� mo�e si� zawiera� mi�dzy 6 a 16 znak�w.<br>\n",
  "es" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n",
  "pt" => "TRANS Password are made only with standards chars and numbers (a-zA-Z0-9) and should be between 6 and 16 chars long.<br>\n");

$txt_clear_array=array(
	"fr" => "TRANS ",
	"en" => "TRANS ",
	"hu" => "TRANS ",
	"it" => "TRANS ",
	"nl" => "TRANS ",
	"ru" => "TRANS ",
	"de" => "TRANS ",
	"zh" => "TRANS ",
	"pl" => "TRANS ",
	"es" => "TRANS ",
	"pt" => "TRANS "
);
?>