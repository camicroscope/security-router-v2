<?php
  // Save as .htpasswd.php
class htpasswd {
    var $fp;
    var $filename;
 
    function htpasswd($filename) {
        @$this->fp = fopen($filename,'r+') or die('Invalid file name');
        $this->filename = $filename;
    }
 
    function user_exists($username) {
        rewind($this->fp);
            while(!feof($this->fp)) {
                $line = rtrim(fgets($this->fp));
                if(!$line)
                    continue;
                $lusername = explode(":",$line)[0];
                if($lusername == $username)
                    return 1;
            }
        return 0;
    }
 
    function crypt_apr1_md5($plainpasswd){    
      $salt = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8);
      $len = strlen($plainpasswd);
      $text = $plainpasswd.'$apr1$'.$salt;
      $bin = pack("H32", md5($plainpasswd.$salt.$plainpasswd));
      for($i = $len; $i > 0; $i -= 16) { $text .= substr($bin, 0, min(16, $i)); }
      for($i = $len; $i > 0; $i >>= 1) { $text .= ($i & 1) ? chr(0) : $plainpasswd{0}; }
      $bin = pack("H32", md5($text));
      for($i = 0; $i < 1000; $i++)
       {
        $new = ($i & 1) ? $plainpasswd : $bin;
        if ($i % 3) $new .= $salt;
        if ($i % 7) $new .= $plainpasswd;
        $new .= ($i & 1) ? $bin : $plainpasswd;
        $bin = pack("H32", md5($new));
      }
     for ($i = 0; $i < 5; $i++)
      {
        $k = $i + 6;
        $j = $i + 12;
        if ($j == 16) $j = 5;
        $tmp = $bin[$i].$bin[$k].$bin[$j].$tmp;
      }
      $tmp = chr(0).chr(0).$bin[11].$tmp;
      $tmp = strtr(strrev(substr(base64_encode($tmp), 2)),"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/", "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
 
      return "$"."apr1"."$".$salt."$".$tmp;
     }
     
     
    function user_add($username,$password) {
        if($this->user_exists($username))
            return false;
        fseek($this->fp,0,SEEK_END);         
        fwrite($this->fp,$username.':'.$password);       
        //fwrite($this->fp,$username.':'.crypt($password,substr(str_replace('+','.',base64_encode(pack('N4', mt_rand(),mt_rand(),mt_rand(),mt_rand()))),0,22))."\n");
        return true;
    }
 
    function user_delete($username) {
        $data = '';
        rewind($this->fp);
        while(!feof($this->fp)) {
            $line = rtrim(fgets($this->fp));
            if(!$line)
                continue;
            $lusername = explode(":",$line)[0];
            if($lusername != $username)
                $data .= $line."\n";
        }
        $this->fp = fopen($this->filename,'w');
        fwrite($this->fp,rtrim($data).(trim($data) ? "\n" : ''));
        fclose($this->fp);
        $this->fp = fopen($this->filename,'r+');
        return true;
    }
 
    function user_update($username,$password) {
        rewind($this->fp);
            while(!feof($this->fp)) {
                $line = rtrim(fgets($this->fp));
                if(!$line)
                    continue;
                $lusername = explode(":",$line)[0];
                if($lusername == $username) {
                    fseek($this->fp,(-15 - strlen($username)),SEEK_CUR);
                    fwrite($this->fp,$username.':'.crypt($password,substr(str_replace('+','.',base64_encode(pack('N4', mt_rand(),mt_rand(),mt_rand(),mt_rand()))),0,22))."\n");
                    return true;
                }
            }
        return false;
    }  

}

?>