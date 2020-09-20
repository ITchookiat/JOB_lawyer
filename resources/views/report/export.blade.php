@php
  function DateThai($strDate){
    $strYear = date("Y")+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "01","02","03","04","05","06","07","08","09","10","11","12");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay/$strMonthThai/$strYear";
  }
  function DateThai2($strDate){
    $strYear = date("Y",strtotime($strDate))+543;
    $strMonth= date("n",strtotime($strDate));
    $strDay= date("d",strtotime($strDate));
    $strMonthCut = Array("" , "มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฏาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $strMonthThai=$strMonthCut[$strMonth];
    return "$strDay $strMonthThai $strYear";
  }

@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Report</title>
  </head>
  <label align="right">วันที่ปริ้น : {{DateThai2(date('Y-m-d'))}}</label>
  <h1 class="card-title p-3" align="center" style="line-height: 3px;">
    รายงานลูกหนี้ {{$typeCus}}
  </h1>
  <hr>
  <body style="margin-top: 0px">
  <br>
  <table border="1">
        <thead>
          <tr align="center" style="line-height: 200%;">
            <th align="center" width="30px" style="background-color: #33FF00;"><b>ลำดับ</b></th>
            <th align="center" width="65px" style="background-color: #BEBEBE;"><b>วันที่ฟ้อง</b></th>
            <th align="center" width="120px" style="background-color: #BEBEBE;"><b>เลขที่สัญญา</b></th>
            <th align="center" width="150px" style="background-color: #BEBEBE;"><b>ชื่อ - นามสกุล</b></th>
            <th align="center" width="200px" style="background-color: #BEBEBE;"><b>ที่อยู่</b></th>
            <th align="center" width="65px" style="background-color: #BEBEBE;"><b>ศาล</b></th>
            <th align="center" width="65px" style="background-color: #BEBEBE;"><b>จำนวนเงิน</b></th>
            <th align="center" width="90px" style="background-color: #BEBEBE;"><b>สถานะ</b></th>
          </tr>
        </thead>
        <tbody>
          @foreach($dataReport as $key => $row)
            <tr>
              <td align="center" width="30px">{{$key+1}}</td>
              <td align="center" width="65px"></td>
              <td align="center" width="120px">{{$row->Number_Cus}}</td>
              <td align="left" width="150px"> {{$row->Name_Cus}}</td>
              <td align="left" width="200px"> {{$row->Address_Cus}}</td>
              <td align="left" width="65px"></td>
              <td align="right" width="65px">{{number_format($row->Principle_Cus,2)}} </td>
              <td align="center" width="90px">
                -
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
  </body>
</html>