<?php
/** afe
*   form kontrol sinifi
*/
error_reporting(~E_ALL & E_NOTICE);
session_start();
class rgx {
    public static $email="/([\s]*)([_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*([ ]+|)@([]+|)([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,}))([\s]*)/i";
}
interface formOlculeri {
   const SURE='5';   //form gönderim süresi
   const ENCOK='10'; //en çok string eleman sayısı
   const ENAZ='2';   //en az string eleman sayısı
}
class formKontrol extends rgx implements formOlculeri {
    public $form;
    public function emailKontrol($deger) {
        if (preg_match(parent::$email, $deger)) {
            $this->form=true;
        }
        return $this->form;
    }
    public function mesajZamanlama($zamanlama=formOlculeri::SURE) {
        // zamanlama baslangictan sonra
        if(empty($_SESSION['baslat'])) {
            $_SESSION['baslat']=time();
        } else {
            if($_SESSION['baslat'] < time()-$zamanlama) {
                unset($_SESSION['baslat']);
            }
            $this->form=false;
        }
        return $this->form;
    }
    public function strgOlc($deger) {
        $cik=strlen($deger);
        return $cik;
    }
    public function encokDeger($degisken, $deger) {
        // string en cok degerini olc
        if($degisken > $deger) {
            $this->form=false;
        }
        return $this->form;
    }
    public function enazDeger($degisken, $deger) {
        //string en az degerini olc
        if($degisken < $deger) {
            $this->form=false;
        }
        return $this->form;
    }
}
class formHatalari extends Exception {}
$formSet=new formKontrol();
try {
    if($formSet->emailKontrol($_GET['form']['email'])==false) {
        throw new formHatalari('hata 1');
    }
    elseif($formSet->mesajZamanlama()==false) {
        throw new formHatalari('hata 2');
    }
    elseif($formSet->encokDeger($formSet->strgOlc($_GET['form']['alDeger']),formKontrol::ENCOK)==false) {
        throw new formHatalari('hata 3');
    }
    elseif($formSet->enazDeger($formSet->strgOlc($_GET['form']['alDeger']),formKontrol::ENAZ)==false) {
        throw new formHatalari('hata 4');
    }
    else {
        $form=true;
    }
} catch(formHatalari $fErr) {
    echo $fErr->getMessage();
}
?>