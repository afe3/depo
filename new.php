/* afe
*  form kontrol sýnýfý
*/
class formKontrol {
	public $form;
	public function emailKontrol($deger) {
		if (!eregi ("^.+@.+\\\\..+$", $deger)) {
			$this->form=false;
		}
		return $this->form;
	}
	public function mesajZamanlama($zamanlama=25) {
		// zamanlama baþlangýçtan sonra
		if(empty($_SESSION['baslat'])) {
			$_SESSION['baslat\']=time();
		} else {
			if($_SESSION['baslat'] < time()-$zamanlama) {
				unset($_SESSION['baslat']);
			}
			$this->form=false;
		}
		return $this->form;
	}
	public function encokDeger($degisken, $deger) {
		// string en çok deðerini ölç
		if($arg >= $deger) {
			$this->form=false;
		}
		return $this->form;
	}
	public function enazDeger($degisken, $deger) {
		//string en az deðerini ölç
		if($arg <= $deger) {
			$this->form=false;
		}
		return $this->form;
	}
}
class formHatalari extends Exception {}
$formSet=new formKontrol();
try {
	if($formSet->emailKontrol($_POST['email'])==false) {
		throw new formHatalari('hata 2');
	}
	elseif($formSet->mesajZamanlama()==false) {
		throw new formHatalari('hata 3');
	}
	elseif($formSet->encokDeger($_POST['getVar'])==false) {
		throw new formHatalari('hata 4');
	}
	elseif($formSet->enazDeger($_POST['getVar'])==false) {
		throw new formHatalari('hata 5');
	}
	else {
		$form=true;
	}
} catch(formHatalari $fErr) {
	echo $fErr->getMessage();
}