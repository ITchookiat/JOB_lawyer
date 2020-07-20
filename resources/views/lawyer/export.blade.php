<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Report</title>
  </head>
  <body style="margin-top: 0px">

    @php
      function DateThai($strDate)
      {
      $strYear = date("Y",strtotime($strDate))+543;
      //$strYear = date("Y",strtotime($strDate));
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));

      $strMonthCut = Array("" , " มกราคม "," กุมภาพันธ์ "," มีนาคม "," เมษายน "," พฤศภาคม "," มิถุนายน "," กรกฏาคม "," สิงหาคม "," กันยายน "," ตุลาคม "," พฤศจิกายน "," ธันวาคม ");
      $strMonthThai=$strMonthCut[$strMonth];

      //return "$strDay $strMonthThai $strYear";
      return "$strDay $strMonthThai $strYear";
      }

      function DateThai2($strDate)
      {
      $strYear = date("Y",strtotime($strDate))+543;
      $Year = substr( $strYear, -2);
      $strMonth= date("n",strtotime($strDate));
      $strDay= date("d",strtotime($strDate));

      $strMonthCut = Array("" , "ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
      $strMonthThai=$strMonthCut[$strMonth];

      return "$strDay-$strMonthThai-$Year";
      }

      $DateNew = date('d-m-Y');

    @endphp

    @php
      function num2thai($thb) {
        list($thb, $ths) = explode('.', $thb);
        $ths = substr($ths.'00', 0, 0);
        $thaiNum = array('','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า');
        $unitBaht = array('บาทถ้วน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน');
        $unitSatang = array('สตางค์','สิบ');
        $THB = '';
        $j = 0;
        for($i=strlen($thb)-1; $i>=0; $i--,$j++) {
        $num = $thb[$i];
        $tnum = $thaiNum[$num];
        $unit = $unitBaht[$j];
        switch(true) {
        case $j==0 && $num==1 && strlen($thb)>1: $tnum = 'เอ็ด'; break;
        case $j==1 && $num==1: $tnum = ''; break;
        case $j==1 && $num==2: $tnum = 'ยี่'; break;
        case $j==6 && $num==1 && strlen($thb)>7: $tnum = 'เอ็ด'; break;
        case $j==7 && $num==1: $tnum = ''; break;
        case $j==7 && $num==2: $tnum = 'ยี่'; break;
        case $j!=0 && $j!=6 && $num==0: $unit = ''; break;
        }
        $S = $tnum . $unit;
        $THB = $S . $THB;
        }
        if($ths=='00') {
        $THS = 'ถ้วน';
        } else {
        $j=0;
        $THS = '';
        for($i=strlen($ths)-1; $i>=0; $i--,$j++) {
        $num = $ths[$i];
        $tnum = $thaiNum[$num];
        $unit = $unitSatang[$j];
        switch(true) {
        case $j==0 && $num==1 && strlen($ths)>1: $tnum = 'เอ็ด'; break;
        case $j==1 && $num==1: $tnum = ''; break;
        case $j==1 && $num==2: $tnum = 'ยี่'; break;
        case $j!=0 && $j!=6 && $num==0: $unit = ''; break;
        }
        $S = $tnum . $unit;
        $THS = $S . $THS;
        }
        }
        return $THB.$THS;
      }

        $thb1 = $dataReport->Finance_approve.".00";
        $Finance_approve = num2thai($thb1);  

        $thb2 = $dataReport->Service_charge.".00";
        $Service_charge = num2thai($thb2);

        $thb3 = $dataReport->Total_amount.".00";
        $Total_amount = num2thai($thb3);

        $thb4 = $dataReport->Balance_amount.".00";
        $Balance_amount = num2thai($thb4);

    @endphp

    <!-- วันที่ปริ้น {{ DateThai($DateNew)}} -->
    @if($ReportType == 1 or $ReportType == 99) {{--โนติสผู้กู้--}}
        <table border="0">
                <tr>
                  <td rowspan="3" width="180px" align="right">
                    <img src="{{ asset('dist/img/logoHafizLaw.png') }}" width="75px" />&nbsp;
                  </td>
                  <td width="350px">&nbsp;</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;สำนักกฎหมาย ฮาฟิต บินสาอิ ทนายความ</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;29/16 หมู่ที่ 2  ต.บานา อ.เมืองปัตตานี จ.ปัตตานี โทร 093-790-3854</td>
                </tr>
        </table>
        <hr>
        <table border="0">
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="30px">เรื่อง</td>
            <td width="150px">ขอให้ชำระหนี้</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px">เรียน</td>
            <td width="220px">{{$dataReport->Name}}</td>
            <td><b>(ผู้กู้)</b></td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="130px">อ้างถึงสัญญากู้เงินเลขที่</td>
            <td width="120px">{{$dataReport->Contract_no}}</td>
            <td width="70px" align="left">ฉบับลงวันที่</td>
            <td width="100px">{{DateThai($dataReport->Date_contract)}}</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="390px">ตามที่ท่านได้ทำสัญญากู้เงินไว้กับสหกรณ์ อิสลามอิบนูอัฟฟาน จำกัด เป็นจำนวนเงิน</td>
            <td width="80px" align="right">{{number_format($dataReport->Finance_approve,2)}}</td>
            <td width="50px">&nbsp;&nbsp;<strong>บาท</strong></td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px">(</td>
            <td width="200px" align="center">{{$Finance_approve}}</td>
            <td width="190px">) และท่านยินดีชำระค่าบริการจำนวน</td>
            <td width="80px" align="right">{{number_format($dataReport->Service_charge,2)}}</td>
            <td width="50px">&nbsp;&nbsp;บาท</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px">(</td>
            <td width="200px" align="center">{{$Service_charge}}</td>
            <td width="210px">) รวมเงินกู้ และค่าบริการเป็นจำนวนเงินทั้งสิ้น</td>
            <td width="60px" align="right">{{number_format($dataReport->Total_amount,2)}}</td>
            <td width="50px">&nbsp;&nbsp;บาท</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="30px">(</td>
            <td width="200px" align="center">{{$Total_amount}}</td>
            <td width="300px">) ซึ่งท่านได้รับเงินกู้ไปครบถ้วนแล้ว โดยท่านตกลงจะชำระให้ครบถ้วน </td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="70px">ภายในวันที่</td>
            <td width="100px">{{DateThai($dataReport->Date_lastdue)}}</td>
            <td width="120px">ในการทำสัญญาครั้งนี้ โดยมี</td>
            <td width="120px">{{$dataReport->Guarantor_name}}</td>
            <td width="150px">เป็นผู้ค้ำประกันการชำระหนี้</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="510px">ภายหลังทำสัญญากู้เงินฉบับนี้ดังกล่าวแล้ว ปรากฏว่าท่านผิดนัดไม่ชำระหนี้ตามสัญญา คงเหลือเงินที่ไม่ชำระเป็นเงินจำนวน</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="80px">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td>( {{$Balance_amount}} )</td>
            <td></td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="570px">ดังนั้น ข้าพเจ้าในฐานะทนายความผู้รับมอบอำนาจจากสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด จึงแจ้งมายังท่านให้นำเงินจำนวน</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="80px">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td>( {{$Balance_amount}} ) มาชำระหนี้แก่สหกรณ์ฯ ณ.ที่ทำการสหกรณ์อิสลาม อิบนูอัฟฟาน </td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="600px">จำกัด หรือข้าพเจ้า ภายในระยะเวลา 30 วัน นับแต่วันที่ท่านได้รับหนังสือฉบับนี้ หากท่านเพิกเฉยมิได้ดำเนินการชำระหนี้ดังกล่าว</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="600px">ให้เสร็จสิ้น ข้าพเจ้ามีความจำเป็นอย่างยิ่งที่จะต้องดำเนินคดีกับท่านตามกฏหมายต่อไป</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="510px">อนึ่ง หากท่านประสงค์จะขอประนอมหนี้ดังกล่าว ขอให้ท่าน และผู้ค้ำประกันไปพบเจ้าหน้าที่เร่งรัดหนี้สิน   ณ. ที่ทำการ</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="600px">สหกรณ์อิสลามอิบนูอัฟฟาน จำกัด หรือข้าพเจ้า ณ สำนักกฏหมายฮาฟิต บินสาอิ ทนายความก่อนครบกำหนด ตามหนังสือฉบับนี้</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="30px"></td>
            <td width="510px">จึงเรียนมาเพื่อดำเนินการด้วย  จักขอบคุณยิ่ง</td>
          </tr>
          <tr><td></td></tr>
          <tr><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="250px"></td>
            <td width="200px">ขอแสดงความนับถือ</td>
          </tr>
          <tr style="line-height: 200%;"><td></td></tr>
          <tr style="line-height: 150%;">
            <td width="245px"></td>
            <td width="200px">( นายฮาฟิต  บินสาอิ )</td>
          </tr>
          <tr style="line-height: 150%;">
            <td width="235px"></td>
            <td width="200px">ทนายความผู้รับมอบอำนาจ</td>
          </tr>
        </table>
    @endif
    @if($ReportType == 2 or $ReportType == 99) {{--โนติสผู้ค้ำ--}}
        <table border="0">
                <tr>
                  <td rowspan="3" width="180px" align="right">
                    <img src="{{ asset('dist/img/logoHafizLaw.png') }}" width="75px" />&nbsp;
                  </td>
                  <td width="350px">&nbsp;</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;สำนักกฎหมาย ฮาฟิต บินสาอิ ทนายความ</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;29/16 หมู่ที่ 2  ต.บานา อ.เมืองปัตตานี จ.ปัตตานี โทร 093-790-3854</td>
                </tr>
        </table>
        <hr>
        <table border="0">
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px">เรื่อง</td>
            <td width="150px">ขอให้ชำระหนี้</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="30px">เรียน</td>
            <td width="220px">{{$dataReport->Guarantor_name}}</td>
            <td><b>(ผู้ค้ำประกัน)</b></td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="130px">อ้างถึงสัญญาเงินกู้เลขที่</td>
            <td width="120px">{{$dataReport->Contract_no}}</td>
            <td width="70px" align="left">ฉบับลงวันที่</td>
            <td width="100px">{{DateThai($dataReport->Date_contract)}}</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="40px">ตามที่</td>
            <td width="180px" align="center">{{$dataReport->Name}}</td>
            <td width="300px">ผู้กู้  ได้ทำสัญญากู้เงินไว้กับสหกรณ์ อิสลามอิบนูอัฟฟาน จำกัด </td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="100px">เป็นเงินจำนวน </td>
            <td width="100px" align="center">{{number_format($dataReport->Finance_approve,2)}} บาท</td>
            <td width="190px">( {{$Finance_approve}} )</td>
            <td> และ ท่านยินดีชำระค่าบริการ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="100px">เป็นเงินจำนวน</td>
            <td width="100px" align="center">{{number_format($dataReport->Service_charge,2)}} บาท</td>
            <td width="190px">( {{$Service_charge}} )</td>
            <td> รวมเงินกู้ และค่าบริการ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="100px">เป็นเงินจำนวนทั้งสิ้น</td>
            <td width="100px" align="center">{{number_format($dataReport->Total_amount,2)}} บาท</td>
            <td width="210px">( {{$Total_amount}} ) </td>
            <td> โดยมีท่านเป็นผู้ค้ำ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="400px">ประกันชำระหนี้ และยอมรับผิดอย่างลูกหนี้ร่วม ความละเอียดท่านทราบดีแล้ว</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="210px">ภายหลังได้ทำสัญญากู้เงินดังกล่าวแล้ว ปรากฏว่า </td>
            <td width="180px" align="center">{{$dataReport->Name}}</td>
            <td width="300px">ผู้กู้ ผิดนัด การชำระหนี้</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="200px">ตามสัญญา โดยยังคงค้างชำระ เป็นจำนวนเงิน</td>
            <td width="100px" align="center">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td width="210px">( {{$Balance_amount}} )</td>
            <td></td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="570px">ดังนั้น ข้าพเจ้าในฐานะทนายความ ผู้รับมอบอำนาจจากสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด   จึงแจ้งมายังท่าน ในฐานะ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="200px">ท่านเป็นผู้ค้ำประกันการชำระหนี้ของ</td>
            <td width="170px" align="center">{{$dataReport->Name}}</td>
            <td width="300px">ผู้กู้ นำเงินจำนวน {{number_format($dataReport->Balance_amount,2)}} บาท</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="220px">( {{$Balance_amount}} )</td>
            <td width="380px"> มาชำระให้กับสหกรณ์ฯ ณ.ที่ทำการสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด </td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="600px">หรือข้าพเจ้า ภายในระยะเวลา 30 วัน นับแต่วันที่ท่านได้รับหนังสือ หรือถือว่าได้รับหนังสือฉบับนี้ หากท่านเพิกเฉยมิได้ดำเนินการ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="600px">ชำระหนี้ดังกล่าวให้เสร็จสิ้น ข้าพเจ้ามีความจำเป็นอย่างยิ่งที่จะต้องดำเนินคดีกับท่านตามกฏหมายต่อไป</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="510px">อนึ่ง หากท่านประสงค์จะขอประนอมหนี้ดังกล่าว ขอให้ท่าน และผู้ค้ำประกันไปพบเจ้าหน้าที่เร่งรัดหนี้สิน   ณ. ที่ทำการ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="550px">สหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด หรือข้าพเจ้า ณ สำนักกฏหมายฮาฟิต บินสาอิ  ทนายความก่อนครบกำหนดตามหนังสือฉบับนี้</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="510px">จึงเรียนมาเพื่อดำเนินการด้วย  จักขอบคุณยิ่ง</td>
          </tr>
          <tr style="line-height: 100%;"><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="250px"></td>
            <td width="200px">ขอแสดงความนับถือ</td>
          </tr>
          <tr style="line-height: 200%;"><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="245px"></td>
            <td width="200px">( นายฮาฟิต  บินสาอิ )</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="235px"></td>
            <td width="200px">ทนายความผู้รับมอบอำนาจ</td>
          </tr>
        </table>
    @endif
    @if($ReportType == 3 or $ReportType == 99) {{--โนติสผู้จำนอง--}}
        <table border="0">
                <tr>
                  <td rowspan="3" width="180px" align="right">
                    <img src="{{ asset('dist/img/logoHafizLaw.png') }}" width="75px" />&nbsp;
                  </td>
                  <td width="350px">&nbsp;</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;สำนักกฎหมาย ฮาฟิต บินสาอิ ทนายความ</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;29/16 หมู่ที่ 2  ต.บานา อ.เมืองปัตตานี จ.ปัตตานี โทร 093-790-3854</td>
                </tr>
        </table>
        <hr>
        <table border="0">
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px">เรื่อง</td>
            <td width="150px">ขอให้ชำระหนี้ และไถ่ถอนจำนอง</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="30px">เรียน</td>
            <td width="220px">{{$dataReport->Name}}</td>
            <td><b>( ผู้จำนอง )</b></td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="130px">อ้างถึงสัญญาเงินกู้เลขที่ </td>
            <td width="120px">{{$dataReport->Contract_no}}</td>
            <td width="70px" align="left">ฉบับลงวันที่</td>
            <td width="100px">{{DateThai($dataReport->Date_contract)}}</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="40px">ตามที่</td>
            <td width="180px" align="center">{{$dataReport->Name}}</td>
            <td width="300px">ผู้กู้  ได้ทำสัญญากู้เงินไว้กับสหกรณ์ อิสลามอิบนูอัฟฟาน จำกัด </td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="100px">เป็นเงินจำนวน </td>
            <td width="100px" align="center">{{number_format($dataReport->Finance_approve,2)}} บาท</td>
            <td width="200px">( {{$Finance_approve}} </td>
            <td> ) และ ท่านยินดีชำระค่าบริการ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="100px">เป็นเงินจำนวน</td>
            <td width="100px" align="center">{{number_format($dataReport->Service_charge,2)}} บาท</td>
            <td width="200px">( {{$Service_charge}} </td>
            <td> ) รวมเงินกู้ และค่าบริการ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="100px">เป็นเงินจำนวนทั้งสิ้น</td>
            <td width="100px" align="center">{{number_format($dataReport->Total_amount,2)}} บาท</td>
            <td width="200px">( {{$Total_amount}} </td>
            <td> ) โดยท่านได้นำที่ดิน</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="600px">จดทะเบียนจำนอง เพื่อค้ำประกันการชำระหนี้ ความละเอียดท่านทราบดีแล้ว</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="210px">ภายหลังได้ทำสัญญากู้เงินดังกล่าวแล้ว ปรากฏว่า </td>
            <td width="180px" align="center">{{$dataReport->Name}}</td>
            <td width="300px">ผู้กู้ ผิดนัด การชำระหนี้</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="200px">ตามสัญญา โดยยังคงค้างชำระ เป็นจำนวนเงิน</td>
            <td width="100px" align="center">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td width="210px">( {{$Balance_amount}} )</td>
            <td></td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="570px">ดังนั้น ข้าพเจ้าในฐานะทนายความ ผู้รับมอบอำนาจจากสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด   จึงแจ้งมายังท่าน ในฐานะ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="130px">ผู้จำนอง ให้นำเงินจำนวน </td>
            <td width="90px">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td width="380px">( {{$Balance_amount}} ) &nbsp; มาชำระให้แก่สหกรณ์ฯ</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="600px">ณ. ที่ทำการสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด หรือข้าพเจ้า ภายในระยะเวลา 60 วัน นับแต่วันที่ท่านได้รับหนังสือฉบับนี้</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="600px">โดยให้ถือว่าหนังสือฉบับนี้เป็นการบอกกล่าวบังคับจำนองตามกฏหมาย และหากท่านไม่มาชำระหนี้เงินตามกำหนดเวลาดังกล่าว</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="600px">ข้าพเจ้ามีความจำเป็นต้องฟ้องร้อง และบังคับจำนองตามกฏหมายต่อไป</td>
          </tr>
          <tr><td></td></tr>
          <tr><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="30px"></td>
            <td width="510px">จึงเรียนมาเพื่อดำเนินการด้วย  จักขอบคุณยิ่ง</td>
          </tr>
          <tr style="line-height: 200%;"><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="250px"></td>
            <td width="200px">ขอแสดงความนับถือ</td>
          </tr>
          <tr style="line-height: 200%;"><td></td></tr>
          <tr style="line-height: 140%;">
            <td width="245px"></td>
            <td width="200px">( นายฮาฟิต  บินสาอิ )</td>
          </tr>
          <tr style="line-height: 140%;">
            <td width="235px"></td>
            <td width="200px">ทนายความผู้รับมอบอำนาจ</td>
          </tr>
        </table>
    @endif
    @if($ReportType == 4 or $ReportType == 99)
        <table border="0">
                <tr>
                  <td rowspan="3" width="180px" align="right">
                    <img src="{{ asset('dist/img/logoHafizLaw.png') }}" width="75px" />&nbsp;
                  </td>
                  <td width="350px">&nbsp;</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;สำนักกฎหมาย ฮาฟิต บินสาอิ ทนายความ</td>
                </tr>
                <tr>
                  <!-- <td></td> -->
                  <td>&nbsp;29/16 หมู่ที่ 2  ต.บานา อ.เมืองปัตตานี จ.ปัตตานี โทร 093-790-3854</td>
                </tr>
        </table>
        <hr>
        <table border="0">
          <tr><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="30px">เรื่อง</td>
            <td width="130px">ขอให้ชำระหนี้</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="30px">เรียน</td>
            <td width="220px">{{$dataReport->Name}}</td>
            <td><b>( ผู้กู้ )</b></td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="130px">อ้างถึงสัญญากู้เงินเลขที่ </td>
            <td width="120px">{{$dataReport->Contract_no}}</td>
            <td width="70px" align="left">ฉบับลงวันที่</td>
            <td width="100px">{{DateThai($dataReport->Date_contract)}}</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="30px"></td>
            <td width="400px">ตามที่ท่านได้ทำสัญญากู้เงินไว้กับสหกรณ์ อิสลามอิบนูอัฟฟาน จำกัด เป็นจำนวนเงิน</td>
            <td width="70px" align="right">{{number_format($dataReport->Finance_approve,2)}}</td>
            <td width="50px"> &nbsp;บาท</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="30px">(</td>
            <td width="200px" align="center">{{$Finance_approve}}</td>
            <td width="190px">) และท่านยินดีชำระค่าบริการจำนวน</td>
            <td width="80px" align="right">{{number_format($dataReport->Service_charge,2)}}</td>
            <td width="50px">&nbsp;&nbsp;บาท</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="30px">(</td>
            <td width="200px" align="center">{{$Service_charge}}</td>
            <td width="210px">) รวมเงินกู้ และค่าบริการเป็นจำนวนเงินทั้งสิ้น</td>
            <td width="60px" align="right">{{number_format($dataReport->Total_amount,2)}}</td>
            <td width="50px">&nbsp;&nbsp;บาท</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="30px">(</td>
            <td width="200px" align="center">{{$Total_amount}}</td>
            <td width="300px">) ซึ่งท่านได้รับเงินกู้ไปครบถ้วนแล้ว โดยท่านตกลงจะชำระให้ครบถ้วน </td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="70px">ภายในวันที่</td>
            <td width="100px">{{DateThai($dataReport->Date_lastdue)}}</td>
            <td width="120px">ในการทำสัญญาครั้งนี้ โดยมี</td>
            <td width="120px">{{$dataReport->Guarantor_name}}</td>
            <td width="130px">เป็นผู้ค้ำประกันการชำระหนี้</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="30px">และ</td>
            <td width="140px">-</td>
            <td width="120px">ได้นำที่ดิน</td>
            <td width="300px">-</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="30px">ตำบล</td>
            <td width="120px">-</td>
            <td width="370px">มาจดทะเบียนจำนองเพื่อค้ำประกันการชำระหนี้ด้วย ความละเอียดท่านทราบดีแล้ว</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="30px"></td>
            <td width="500px">ภายหลังได้ทำสัญญากู้เงินดังกล่าวแล้ว ปรากฏว่าท่านผิดนัดการชำระหนี้ตามสัญญา ยังคงเหลือเงินที่ยังไม่ชำระเป็นเงิน</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="50px">จำนวน</td>
            <td width="120px" align="center">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td width="210px">( {{$Balance_amount}} )</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="30px"></td>
            <td width="570px">ดังนั้น ข้าพเจ้าในฐานะทนายความผู้รับมอบอำนาจจากสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด จึงแจ้งมายังท่านให้นำเงิน</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="40px">จำนวน </td>
            <td width="100px" align="center">{{number_format($dataReport->Balance_amount,2)}} บาท</td>
            <td width="250px">( {{$Balance_amount}} )</td>
            <td width="150px">&nbsp; มาชำระแก่สหกรณ์ฯ ณ.ที่ทำการ</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="600px">สหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด หรือข้าพเจ้า ภายในระยะเวลา 60 วัน นับแต่วันที่ท่านได้รับหนังสือฉบับนี้ หากท่านเพิกเฉย</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="600px">มิได้ดำเนินการชำระหนี้ดังกล่าวให้เสร็จสิ้น ข้าพเจ้ามีความจำเป็นอย่างยิ่งที่จะต้องดำเนินคดีกับท่านตามกฏหมายต่อไป</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="30px"></td>
            <td width="570px">อนึ่ง หากท่านประสงค์จะขอประนอมหนี้ดังกล่าว ขอให้ท่าน / ผู้ค้ำประกัน / และผู้จำนองไปพบเจ้าหน้าที่เร่งรัดหนี้สิน</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="600px">ณ. ที่ทำการสหกรณ์อิสลาม อิบนูอัฟฟาน จำกัด หรือ ข้าพเจ้า ณ. สำนักกฏหมายฮาฟิต  บินสาอิ  ทนายความ ก่อนครบกำหนด</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="600px">ตามหนังสือฉบับนี้</td>
          </tr>
          <tr><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="30px"></td>
            <td width="510px">จึงเรียนมาเพื่อดำเนินการด้วย  จักขอบคุณยิ่ง</td>
          </tr>
          <tr style="line-height: 100%;"><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="250px"></td>
            <td width="200px">ขอแสดงความนับถือ</td>
          </tr>
          <tr style="line-height: 180%;"><td></td></tr>
          <tr style="line-height: 135%;">
            <td width="245px"></td>
            <td width="200px">( นายฮาฟิต  บินสาอิ )</td>
          </tr>
          <tr style="line-height: 135%;">
            <td width="235px"></td>
            <td width="200px">ทนายความผู้รับมอบอำนาจ</td>
          </tr>
        </table>
    @endif

  </body>
</html>
