<?php
function h($value){
    return htmlspecialchars($value,ENT_QUOTES);
}

function ReadFileData($filename){
    $fp = fopen($filename, 'r');
    $data = [];
    $data[] = [];
    $i = 0;

    // ファイルの最後の行を読み込むためのバッファ
    $lastLine = '';

    // 行末までループ処理
    while (!feof($fp)) {
        $line = fgets($fp);
            $lastLine = $line;  // 最後に読み込んだ行を記録
            $data[$i] = explode(",", $line);
            $i++;
    }
    fclose($fp);

    // 最後の行が改行だけの場合は削除
    if (count($data) > 0 && trim($lastLine) === '') {
        array_pop($data);
    }

    return $data;
}

class chart{
    protected $attend = 0;
    protected $absent = 0;
    protected $suspend = 0;

    public function setAttend($value){$this->attend = $value;}
    public function getAttend(){return $this->attend;}

    public function setAbsent($value){$this->absent = $value;}
    public function getAbsent(){return $this->absent;}

    public function setSuspend($value){$this->suspend = $value;}
    public function getSuspend(){return $this->suspend;}

    public function setData($data){
    if(in_array('出席', $data)){$this->attend++;}
    else if(in_array('欠席', $data)){$this->absent++;}
    else if(in_array('保留', $data)){$this->suspend++;}
    }
}

?>