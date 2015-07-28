<?php
namespace Byte\Storage;
class Storage
{
  public function __construct($apiKey)
  {
    $this->apiKey = $apiKey;
  }
  public function get($id)
  {
    $url = 'http://storage.byte.gs/file/'.(int)$id;
    $ch = curl_init($url);
    $request_headers = ["X-Auth-Token: ".$this->apiKey];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $r = curl_getinfo($ch);
    if($r["http_code"]!=200)
    {
      $detais = json_decode($result, true);
      if(isset($detais["msg"]))
      {
        throw new \Exception($detais["msg"], 1);
      }
      else {
        throw new \Exception("HTTP Return ".$r["http_code"], 1);
      }
    }
    return $result;
  }
  public function upload($filepath, $public = 0)
  {
    $filename = realpath($filepath);
    $url = 'http://storage.byte.gs/file';
    $finfo = new \finfo(FILEINFO_MIME_TYPE);
    $mimetype = $finfo->file($filename);
    $ch = curl_init($url);
    $request_headers = ["X-Auth-Token: ".$this->apiKey];
    $cfile = curl_file_create($filename, $mimetype, basename($filename));
    $data = ['file' => $cfile, 'public' => $public];
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    $r = curl_getinfo($ch);
    if($r["http_code"]!=200)
    {
      $detais = json_decode($result, true);
      if(isset($detais["msg"]))
      {
        throw new \Exception($detais["msg"], 1);
      }
      else {
        throw new \Exception("HTTP Return ".$r["http_code"], 1);
      }
    }
    $detais = json_decode($result, true);
    $res = array();
    $res["id"] = $detais["id"];
    $res["md5"] = $detais["md5"];
    if($public==1)
    {
      $res["link"] = "http://storage.byte.gs/file/".$res["id"]."?md5=".$res["md5"];
    }
    return $res;
  }
  public function delete($id)
  {
    $url = 'http://storage.byte.gs/file/'.(int)$id;
    $ch = curl_init($url);
    $request_headers = ["X-Auth-Token: ".$this->apiKey];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    $result = curl_exec($ch);
    var_dump($result);
    $r = curl_getinfo($ch);
    if($r["http_code"]!=200)
    {
      $detais = json_decode($result, true);
      if(isset($detais["msg"]))
      {
        throw new \Exception($detais["msg"], 1);
      }
      else {
        throw new \Exception("HTTP Return ".$r["http_code"], 1);
      }
    }
    else{
      return true;
    }
    #return $result;
  }
}
