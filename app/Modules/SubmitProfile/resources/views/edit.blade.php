@extends('admin.layouts.admin_master')
@section('title')
    Submit Profile Create
@endsection
<style>
    #contact_select {


        background: #FFF;

        color: #aaa;
    }
   
</style>

@section('content')
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Submit Profile</h1>

                        </div>

                    </div>

                </div>

                <div class="col-lg-6 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Submit Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <section id="main-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title pr">
                        <h6><b class="breadcrumb-item">Actor Profile</b></h6>
                    </div>
                    <hr />
                    <div class="card-body">
                        <form action="{{ route('admin.submitprofile.store',["profileId"=>$userProfile->id,"userId"=> $userProfile->user_id]) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" id="contact"><b>Name
                                            </b><span style="color:red;">*</span>
                                        </label>
                                        <input type="text" name="name" class="form-control" id="staticName"
                                            value="{{ old('name', $userProfile->user->name) }}" />
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="ethnicity"><b>Ethnicity</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <select name="ethnicity" class="form-control" id="ethnicity">
                                            <option selected>Please Select</option>

                                            <option value="Andhra Pradesh"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Andhra Pradesh') selected @endif>Andhra Pradesh</option>
                                            <option value="Andaman &amp; Nicobar"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Andaman & Nicobar') selected @endif>Andaman &amp;
                                                Nicobar </option>
                                            <option value="Arunachal Pradesh"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Arunachal Pradesh') selected @endif>Arunachal Pradesh
                                            </option>
                                            <option value="Assam" @if (isset($userProfile) && $userProfile->ethnicity == 'Assam') selected @endif>Assam
                                            </option>
                                            <option value="Bihar" @if (isset($userProfile) && $userProfile->ethnicity == 'Bihar') selected @endif>Bihar
                                            </option>
                                            <option value="Chandigarh" @if (isset($userProfile) && $userProfile->ethnicity == 'Chandigarh') selected @endif>
                                                Chandigarh</option>
                                            <option value="Chhattisgarh" @if (isset($userProfile) && $userProfile->ethnicity == 'Chhattisgarh') selected @endif>
                                                Chhattisgarh</option>
                                            <option value="Dadar &amp; Nagar Haveli"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Dadar & Nagar Haveli') selected @endif>Dadar &amp;
                                                Nagar Haveli
                                            </option>
                                            <option value="Daman &amp; Diu"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Daman & Diu') selected @endif>Daman &amp; Diu</option>
                                            <option value="Delhi" @if (isset($userProfile) && $userProfile->ethnicity == 'Delhi') selected @endif>Delhi
                                            </option>
                                            <option value="Lakshadweep" @if (isset($userProfile) && $userProfile->ethnicity == 'Lakshadweep') selected @endif>
                                                Lakshadweep</option>
                                            <option value="Puducherry" @if (isset($userProfile) && $userProfile->ethnicity == 'Puducherry') selected @endif>
                                                Puducherry</option>
                                            <option value="Goa" @if (isset($userProfile) && $userProfile->ethnicity == 'Goa') selected @endif>Goa
                                            </option>
                                            <option value="Gujarat" @if (isset($userProfile) && $userProfile->ethnicity == 'Gujarat') selected @endif>
                                                Gujarat</option>
                                            <option value="Haryana" @if (isset($userProfile) && $userProfile->ethnicity == 'Haryana') selected @endif>
                                                Haryana</option>
                                            <option value="Himachal Pradesh"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Himachal Pradesh') selected @endif>Himachal Pradesh
                                            </option>
                                            <option value="Jammu &amp; Kashmir"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Jammu & Kashmir') selected @endif>Jammu &amp; Kashmir
                                            </option>
                                            <option value="Jharkhand" @if (isset($userProfile) && $userProfile->ethnicity == 'Jharkhand') selected @endif>
                                                Jharkhand</option>
                                            <option value="Karnataka" @if (isset($userProfile) && $userProfile->ethnicity == 'Karnataka') selected @endif>
                                                Karnataka</option>
                                            <option value="Kerala" @if (isset($userProfile) && $userProfile->ethnicity == 'Kerala') selected @endif>
                                                Kerala</option>
                                            <option value="Madhya Pradesh"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Madhya Pradesh') selected @endif>Madhya Pradesh</option>
                                            <option value="Maharashtra" @if (isset($userProfile) && $userProfile->ethnicity == 'Maharashtra') selected @endif>
                                                Maharashtra</option>
                                            <option value="Manipur" @if (isset($userProfile) && $userProfile->ethnicity == 'Manipur') selected @endif>
                                                Manipur</option>
                                            <option value="Meghalaya" @if (isset($userProfile) && $userProfile->ethnicity == 'Meghalaya') selected @endif>
                                                Meghalaya</option>
                                            <option value="Mizoram" @if (isset($userProfile) && $userProfile->ethnicity == 'Mizoram') selected @endif>
                                                Mizoram</option>
                                            <option value="Nagaland" @if (isset($userProfile) && $userProfile->ethnicity == 'Nagaland') selected @endif>
                                                Nagaland</option>
                                            <option value="Odisha" @if (isset($userProfile) && $userProfile->ethnicity == 'Odisha') selected @endif>
                                                Odisha</option>
                                            <option value="Other" @if (isset($userProfile) && $userProfile->ethnicity == 'Other') selected @endif>Other
                                            </option>
                                            <option value="Punjab" @if (isset($userProfile) && $userProfile->ethnicity == 'Punjab') selected @endif>
                                                Punjab</option>
                                            <option value="Rajasthan" @if (isset($userProfile) && $userProfile->ethnicity == 'Rajasthan') selected @endif>
                                                Rajasthan</option>
                                            <option value="Sikkim" @if (isset($userProfile) && $userProfile->ethnicity == 'Tamil Nadu') selected @endif>
                                                Sikkim</option>
                                            <option value="Tamil Nadu" @if (isset($userProfile) && $userProfile->ethnicity == 'Telangana') selected @endif>
                                                Tamil Nadu</option>
                                            <option value="Telangana" @if (isset($userProfile) && $userProfile->ethnicity == 'Tripura') selected @endif>
                                                Telangana</option>
                                            <option value="Tripura" @if (isset($userProfile) && $userProfile->ethnicity == 'Uttar Pradesh') selected @endif>
                                                Tripura</option>
                                            <option value="Uttar Pradesh"
                                                @if (isset($userProfile) && $userProfile->ethnicity == 'Bihar') selected @endif>Uttar Pradesh</option>
                                            <option value="Uttarakhand" @if (isset($userProfile) && $userProfile->ethnicity == 'Uttarakhand') selected @endif>
                                                Uttarakhand</option>
                                            <option value="West Bengal" @if (isset($userProfile) && $userProfile->ethnicity == 'West Bengal') selected @endif>
                                                West Bengal</option>
                                        </select>
                                        @error('ethnicity')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>



                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label" id="contact"><b>Contact
                                        </b><span style="color:red;">*</span>
                                    </label>

                                    <div class="input-group mb-3">
                                        <select name="countryCode" id="" class="form-control" style=" width: 30%">
                                            <option data-countrycode="IN"   @if (isset($userProfile) && $userProfile->countryCode == '91') selected @endif value="91" selected="">India (+91)</option>
                                            <option data-countrycode="GB" @if (isset($userProfile) && $userProfile->countryCode == '44') selected @endif value="44">UK (+44)</option>
                                            <option data-countrycode="US" @if (isset($userProfile) && $userProfile->countryCode == '1') selected @endif value="1">USA (+1)</option>
                                            <optgroup label="Other countries">
                                                <option data-countrycode="DZ"  @if (isset($userProfile) && $userProfile->countryCode == '213') selected @endif  value="213">Algeria (+213)</option>
                                                <option data-countrycode="AD"  @if (isset($userProfile) && $userProfile->countryCode == '376') selected @endif value="376">Andorra (+376)</option>
                                                <option data-countrycode="AO"  @if (isset($userProfile) && $userProfile->countryCode == '244') selected @endif value="244">Angola (+244)</option>
                                                <option data-countrycode="AI"  @if (isset($userProfile) && $userProfile->countryCode == '1264') selected @endif value="1264">Anguilla (+1264)</option>
                                                <option data-countrycode="AG"  @if (isset($userProfile) && $userProfile->countryCode == '1268') selected @endif value="1268">Antigua &amp; Barbuda (+1268)
                                                </option>
                                                <option data-countrycode="AR" @if (isset($userProfile) && $userProfile->countryCode == '54') selected @endif value="54">Argentina (+54)</option>
                                                <option data-countrycode="AM" @if (isset($userProfile) && $userProfile->countryCode == '374') selected @endif value="374">Armenia (+374)</option>
                                                <option data-countrycode="AW" @if (isset($userProfile) && $userProfile->countryCode == '297') selected @endif value="297">Aruba (+297)</option>
                                                <option data-countrycode="AU" @if (isset($userProfile) && $userProfile->countryCode == '61') selected @endif value="61">Australia (+61)</option>
                                                <option data-countrycode="AT" @if (isset($userProfile) && $userProfile->countryCode == '43') selected @endif value="43">Austria (+43)</option>
                                                <option data-countrycode="AZ" @if (isset($userProfile) && $userProfile->countryCode == '994') selected @endif value="994">Azerbaijan (+994)</option>
                                                <option data-countrycode="BS" @if (isset($userProfile) && $userProfile->countryCode == '1242') selected @endif value="1242">Bahamas (+1242)</option>
                                                <option data-countrycode="BH" @if (isset($userProfile) && $userProfile->countryCode == '973') selected @endif value="973">Bahrain (+973)</option>
                                                <option data-countrycode="BD" @if (isset($userProfile) && $userProfile->countryCode == '880') selected @endif value="880">Bangladesh (+880)</option>
                                                <option data-countrycode="BB" @if (isset($userProfile) && $userProfile->countryCode == '1246') selected @endif value="1246">Barbados (+1246)</option>
                                                <option data-countrycode="BY" @if (isset($userProfile) && $userProfile->countryCode == '375') selected @endif value="375">Belarus (+375)</option>
                                                <option data-countrycode="BE" @if (isset($userProfile) && $userProfile->countryCode == '32') selected @endif value="32">Belgium (+32)</option>
                                                <option data-countrycode="BZ" @if (isset($userProfile) && $userProfile->countryCode == '501') selected @endif value="501">Belize (+501)</option>
                                                <option data-countrycode="BJ" @if (isset($userProfile) && $userProfile->countryCode == '229') selected @endif value="229">Benin (+229)</option>
                                                <option data-countrycode="BM" @if (isset($userProfile) && $userProfile->countryCode == '1441') selected @endif value="1441">Bermuda (+1441)</option>
                                                <option data-countrycode="BT" @if (isset($userProfile) && $userProfile->countryCode == '975') selected @endif value="975">Bhutan (+975)</option>
                                                <option data-countrycode="BO" @if (isset($userProfile) && $userProfile->countryCode == '591') selected @endif value="591">Bolivia (+591)</option>
                                                <option data-countrycode="BA" @if (isset($userProfile) && $userProfile->countryCode == '387') selected @endif value="387">Bosnia Herzegovina (+387)
                                                </option>
                                                <option data-countrycode="BW"@if (isset($userProfile) && $userProfile->countryCode == '267') selected @endif value="267">Botswana (+267)</option>
                                                <option data-countrycode="BR"@if (isset($userProfile) && $userProfile->countryCode == '55') selected @endif value="55">Brazil (+55)</option>
                                                <option data-countrycode="BN"@if (isset($userProfile) && $userProfile->countryCode == '673') selected @endif value="673">Brunei (+673)</option>
                                                <option data-countrycode="BG"@if (isset($userProfile) && $userProfile->countryCode == '359') selected @endif value="359">Bulgaria (+359)</option>
                                                <option data-countrycode="BF"@if (isset($userProfile) && $userProfile->countryCode == '226') selected @endif value="226">Burkina Faso (+226)</option>
                                                <option data-countrycode="BI"@if (isset($userProfile) && $userProfile->countryCode == '257') selected @endif value="257">Burundi (+257)</option>
                                                <option data-countrycode="KH"@if (isset($userProfile) && $userProfile->countryCode == '855') selected @endif value="855">Cambodia (+855)</option>
                                                <option data-countrycode="CM"@if (isset($userProfile) && $userProfile->countryCode == '237') selected @endif value="237">Cameroon (+237)</option>
                                                <option data-countrycode="CA"@if (isset($userProfile) && $userProfile->countryCode == '1') selected @endif value="1">Canada (+1)</option>
                                                <option data-countrycode="CV"@if (isset($userProfile) && $userProfile->countryCode == '238') selected @endif value="238">Cape Verde Islands (+238)
                                                </option>
                                                <option data-countrycode="KY" @if (isset($userProfile) && $userProfile->countryCode == '1345') selected @endif value="1345">Cayman Islands (+1345)
                                                </option>
                                                <option data-countrycode="CF" @if (isset($userProfile) && $userProfile->countryCode == '236') selected @endif value="236">Central African Republic
                                                    (+236)</option>
                                                <option data-countrycode="CL"@if (isset($userProfile) && $userProfile->countryCode == '56') selected @endif  value="56">Chile (+56)</option>
                                                <option data-countrycode="CN"@if (isset($userProfile) && $userProfile->countryCode == '86') selected @endif value="86">China (+86)</option>
                                                <option data-countrycode="CO"@if (isset($userProfile) && $userProfile->countryCode == '57') selected @endif value="57">Colombia (+57)</option>
                                                <option data-countrycode="KM"@if (isset($userProfile) && $userProfile->countryCode == '269') selected @endif value="269">Comoros (+269)</option>
                                                <option data-countrycode="CG"@if (isset($userProfile) && $userProfile->countryCode == '242') selected @endif value="242">Congo (+242)</option>
                                                <option data-countrycode="CK"@if (isset($userProfile) && $userProfile->countryCode == '682') selected @endif value="682">Cook Islands (+682)</option>
                                                <option data-countrycode="CR"@if (isset($userProfile) && $userProfile->countryCode == '506') selected @endif value="506">Costa Rica (+506)</option>
                                                <option data-countrycode="HR"@if (isset($userProfile) && $userProfile->countryCode == '385') selected @endif value="385">Croatia (+385)</option>
                                                <option data-countrycode="CU"@if (isset($userProfile) && $userProfile->countryCode == '53') selected @endif value="53">Cuba (+53)</option>
                                                <option data-countrycode="CY"@if (isset($userProfile) && $userProfile->countryCode == '90392') selected @endif value="90392">Cyprus North (+90392)
                                                </option>
                                                <option data-countrycode="CY"@if (isset($userProfile) && $userProfile->countryCode == '357') selected @endif value="357">Cyprus South (+357)</option>
                                                <option data-countrycode="CZ"@if (isset($userProfile) && $userProfile->countryCode == '42') selected @endif value="42">Czech Republic (+42)</option>
                                                <option data-countrycode="DK"@if (isset($userProfile) && $userProfile->countryCode == '45') selected @endif value="45">Denmark (+45)</option>
                                                <option data-countrycode="DJ"@if (isset($userProfile) && $userProfile->countryCode == '253') selected @endif value="253">Djibouti (+253)</option>
                                                <option data-countrycode="DM"@if (isset($userProfile) && $userProfile->countryCode == '1809') selected @endif value="1809">Dominica (+1809)</option>
                                                <option data-countrycode="DO"@if (isset($userProfile) && $userProfile->countryCode == '1809') selected @endif value="1809">Dominican Republic (+1809)
                                                </option>
                                                <option data-countrycode="EC"@if (isset($userProfile) && $userProfile->countryCode == '593') selected @endif value="593">Ecuador (+593)</option>
                                                <option data-countrycode="EG"@if (isset($userProfile) && $userProfile->countryCode == '20') selected @endif value="20">Egypt (+20)</option>
                                                <option data-countrycode="SV"@if (isset($userProfile) && $userProfile->countryCode == '503') selected @endif value="503">El Salvador (+503)</option>
                                                <option data-countrycode="GQ"@if (isset($userProfile) && $userProfile->countryCode == '240') selected @endif value="240">Equatorial Guinea (+240)
                                                </option>
                                                <option data-countrycode="ER"@if (isset($userProfile) && $userProfile->countryCode == '291') selected @endif value="291">Eritrea (+291)</option>
                                                <option data-countrycode="EE"@if (isset($userProfile) && $userProfile->countryCode == '372') selected @endif value="372">Estonia (+372)</option>
                                                <option data-countrycode="ET"@if (isset($userProfile) && $userProfile->countryCode == '251') selected @endif value="251">Ethiopia (+251)</option>
                                                <option data-countrycode="FK"@if (isset($userProfile) && $userProfile->countryCode == '500') selected @endif value="500">Falkland Islands (+500)
                                                </option>
                                                <option data-countrycode="FO"@if (isset($userProfile) && $userProfile->countryCode == '298') selected @endif value="298">Faroe Islands (+298)</option>
                                                <option data-countrycode="FJ"@if (isset($userProfile) && $userProfile->countryCode == '679') selected @endif value="679">Fiji (+679)</option>
                                                <option data-countrycode="FI"@if (isset($userProfile) && $userProfile->countryCode == '358') selected @endif value="358">Finland (+358)</option>
                                                <option data-countrycode="FR"@if (isset($userProfile) && $userProfile->countryCode == '33') selected @endif value="33">France (+33)</option>
                                                <option data-countrycode="GF"@if (isset($userProfile) && $userProfile->countryCode == '594') selected @endif value="594">French Guiana (+594)</option>
                                                <option data-countrycode="PF"@if (isset($userProfile) && $userProfile->countryCode == '689') selected @endif value="689">French Polynesia (+689)
                                                </option>
                                                <option data-countrycode="GA"@if (isset($userProfile) && $userProfile->countryCode == '241') selected @endif value="241">Gabon (+241)</option>
                                                <option data-countrycode="GM"@if (isset($userProfile) && $userProfile->countryCode == '220') selected @endif value="220">Gambia (+220)</option>
                                                <option data-countrycode="GE"@if (isset($userProfile) && $userProfile->countryCode == '7880') selected @endif value="7880">Georgia (+7880)</option>
                                                <option data-countrycode="DE"@if (isset($userProfile) && $userProfile->countryCode == '49') selected @endif value="49">Germany (+49)</option>
                                                <option data-countrycode="GH"@if (isset($userProfile) && $userProfile->countryCode == '233') selected @endif value="233">Ghana (+233)</option>
                                                <option data-countrycode="GI"@if (isset($userProfile) && $userProfile->countryCode == '350') selected @endif value="350">Gibraltar (+350)</option>
                                                <option data-countrycode="GR"@if (isset($userProfile) && $userProfile->countryCode == '30') selected @endif value="30">Greece (+30)</option>
                                                <option data-countrycode="GL"@if (isset($userProfile) && $userProfile->countryCode == '299') selected @endif value="299">Greenland (+299)</option>
                                                <option data-countrycode="GD"@if (isset($userProfile) && $userProfile->countryCode == '1473') selected @endif value="1473">Grenada (+1473)</option>
                                                <option data-countrycode="GP"@if (isset($userProfile) && $userProfile->countryCode == '590') selected @endif value="590">Guadeloupe (+590)</option>
                                                <option data-countrycode="GU"@if (isset($userProfile) && $userProfile->countryCode == '671') selected @endif value="671">Guam (+671)</option>
                                                <option data-countrycode="GT"@if (isset($userProfile) && $userProfile->countryCode == '502') selected @endif value="502">Guatemala (+502)</option>
                                                <option data-countrycode="GN"@if (isset($userProfile) && $userProfile->countryCode == '224') selected @endif value="224">Guinea (+224)</option>
                                                <option data-countrycode="GW"@if (isset($userProfile) && $userProfile->countryCode == '245') selected @endif value="245">Guinea - Bissau (+245)
                                                </option>
                                                <option data-countrycode="GY"@if (isset($userProfile) && $userProfile->countryCode == '592') selected @endif value="592">Guyana (+592)</option>
                                                <option data-countrycode="HT"@if (isset($userProfile) && $userProfile->countryCode == '509') selected @endif value="509">Haiti (+509)</option>
                                                <option data-countrycode="HN"@if (isset($userProfile) && $userProfile->countryCode == '504') selected @endif value="504">Honduras (+504)</option>
                                                <option data-countrycode="HK"@if (isset($userProfile) && $userProfile->countryCode == '852') selected @endif value="852">Hong Kong (+852)</option>
                                                <option data-countrycode="HU"@if (isset($userProfile) && $userProfile->countryCode == '36') selected @endif value="36">Hungary (+36)</option>
                                                <option data-countrycode="IS"@if (isset($userProfile) && $userProfile->countryCode == '354') selected @endif value="354">Iceland (+354)</option>
                                                <option data-countrycode="IN"@if (isset($userProfile) && $userProfile->countryCode == '91') selected @endif value="91">India (+91)</option>
                                                <option data-countrycode="ID"@if (isset($userProfile) && $userProfile->countryCode == '62') selected @endif value="62">Indonesia (+62)</option>
                                                <option data-countrycode="IR"@if (isset($userProfile) && $userProfile->countryCode == '98') selected @endif value="98">Iran (+98)</option>
                                                <option data-countrycode="IQ"@if (isset($userProfile) && $userProfile->countryCode == '964') selected @endif value="964">Iraq (+964)</option>
                                                <option data-countrycode="IE"@if (isset($userProfile) && $userProfile->countryCode == '353') selected @endif value="353">Ireland (+353)</option>
                                                <option data-countrycode="IL"@if (isset($userProfile) && $userProfile->countryCode == '972') selected @endif value="972">Israel (+972)</option>
                                                <option data-countrycode="IT"@if (isset($userProfile) && $userProfile->countryCode == '39') selected @endif value="39">Italy (+39)</option>
                                                <option data-countrycode="JM"@if (isset($userProfile) && $userProfile->countryCode == '1876') selected @endif value="1876">Jamaica (+1876)</option>
                                                <option data-countrycode="JP"@if (isset($userProfile) && $userProfile->countryCode == '81') selected @endif value="81">Japan (+81)</option>
                                                <option data-countrycode="JO"@if (isset($userProfile) && $userProfile->countryCode == '962') selected @endif value="962">Jordan (+962)</option>
                                                <option data-countrycode="KZ"@if (isset($userProfile) && $userProfile->countryCode == '7') selected @endif value="7">Kazakhstan (+7)</option>
                                                <option data-countrycode="KE"@if (isset($userProfile) && $userProfile->countryCode == '254') selected @endif value="254">Kenya (+254)</option>
                                                <option data-countrycode="KI"@if (isset($userProfile) && $userProfile->countryCode == '686') selected @endif value="686">Kiribati (+686)</option>
                                                <option data-countrycode="KP"@if (isset($userProfile) && $userProfile->countryCode == '850') selected @endif value="850">Korea North (+850)</option>
                                                <option data-countrycode="KR"@if (isset($userProfile) && $userProfile->countryCode == '82') selected @endif value="82">Korea South (+82)</option>
                                                <option data-countrycode="KW"@if (isset($userProfile) && $userProfile->countryCode == '965') selected @endif value="965">Kuwait (+965)</option>
                                                <option data-countrycode="KG"@if (isset($userProfile) && $userProfile->countryCode == '996') selected @endif value="996">Kyrgyzstan (+996)</option>
                                                <option data-countrycode="LA"@if (isset($userProfile) && $userProfile->countryCode == '856') selected @endif value="856">Laos (+856)</option>
                                                <option data-countrycode="LV"@if (isset($userProfile) && $userProfile->countryCode == '371') selected @endif value="371">Latvia (+371)</option>
                                                <option data-countrycode="LB"@if (isset($userProfile) && $userProfile->countryCode == '961') selected @endif value="961">Lebanon (+961)</option>
                                                <option data-countrycode="LS"@if (isset($userProfile) && $userProfile->countryCode == '266') selected @endif value="266">Lesotho (+266)</option>
                                                <option data-countrycode="LR"@if (isset($userProfile) && $userProfile->countryCode == '231') selected @endif value="231">Liberia (+231)</option>
                                                <option data-countrycode="LY"@if (isset($userProfile) && $userProfile->countryCode == '218') selected @endif value="218">Libya (+218)</option>
                                                <option data-countrycode="LI"@if (isset($userProfile) && $userProfile->countryCode == '417') selected @endif value="417">Liechtenstein (+417)</option>
                                                <option data-countrycode="LT"@if (isset($userProfile) && $userProfile->countryCode == '370') selected @endif value="370">Lithuania (+370)</option>
                                                <option data-countrycode="LU"@if (isset($userProfile) && $userProfile->countryCode == '352') selected @endif value="352">Luxembourg (+352)</option>
                                                <option data-countrycode="MO"@if (isset($userProfile) && $userProfile->countryCode == '853') selected @endif value="853">Macao (+853)</option>
                                                <option data-countrycode="MK"@if (isset($userProfile) && $userProfile->countryCode == '389') selected @endif value="389">Macedonia (+389)</option>
                                                <option data-countrycode="MG"@if (isset($userProfile) && $userProfile->countryCode == '261') selected @endif value="261">Madagascar (+261)</option>
                                                <option data-countrycode="MW"@if (isset($userProfile) && $userProfile->countryCode == '265') selected @endif value="265">Malawi (+265)</option>
                                                <option data-countrycode="MY"@if (isset($userProfile) && $userProfile->countryCode == '60') selected @endif value="60">Malaysia (+60)</option>
                                                <option data-countrycode="MV"@if (isset($userProfile) && $userProfile->countryCode == '960') selected @endif value="960">Maldives (+960)</option>
                                                <option data-countrycode="ML"@if (isset($userProfile) && $userProfile->countryCode == '223') selected @endif value="223">Mali (+223)</option>
                                                <option data-countrycode="MT"@if (isset($userProfile) && $userProfile->countryCode == '356') selected @endif value="356">Malta (+356)</option>
                                                <option data-countrycode="MH"@if (isset($userProfile) && $userProfile->countryCode == '692') selected @endif value="692">Marshall Islands (+692)
                                                </option>
                                                <option data-countrycode="MQ"@if (isset($userProfile) && $userProfile->countryCode == '596') selected @endif value="596">Martinique (+596)</option>
                                                <option data-countrycode="MR"@if (isset($userProfile) && $userProfile->countryCode == '222') selected @endif value="222">Mauritania (+222)</option>
                                                <option data-countrycode="YT"@if (isset($userProfile) && $userProfile->countryCode == '269') selected @endif value="269">Mayotte (+269)</option>
                                                <option data-countrycode="MX"@if (isset($userProfile) && $userProfile->countryCode == '52') selected @endif value="52">Mexico (+52)</option>
                                                <option data-countrycode="FM"@if (isset($userProfile) && $userProfile->countryCode == '691') selected @endif value="691">Micronesia (+691)</option>
                                                <option data-countrycode="MD"@if (isset($userProfile) && $userProfile->countryCode == '373') selected @endif value="373">Moldova (+373)</option>
                                                <option data-countrycode="MC"@if (isset($userProfile) && $userProfile->countryCode == '377') selected @endif value="377">Monaco (+377)</option>
                                                <option data-countrycode="MN"@if (isset($userProfile) && $userProfile->countryCode == '976') selected @endif value="976">Mongolia (+976)</option>
                                                <option data-countrycode="MS"@if (isset($userProfile) && $userProfile->countryCode == '1664') selected @endif value="1664">Montserrat (+1664)</option>
                                                <option data-countrycode="MA"@if (isset($userProfile) && $userProfile->countryCode == '212') selected @endif value="212">Morocco (+212)</option>
                                                <option data-countrycode="MZ"@if (isset($userProfile) && $userProfile->countryCode == '258') selected @endif value="258">Mozambique (+258)</option>
                                                <option data-countrycode="MN"@if (isset($userProfile) && $userProfile->countryCode == '95') selected @endif value="95">Myanmar (+95)</option>
                                                <option data-countrycode="NA"@if (isset($userProfile) && $userProfile->countryCode == '264') selected @endif value="264">Namibia (+264)</option>
                                                <option data-countrycode="NR"@if (isset($userProfile) && $userProfile->countryCode == '674') selected @endif value="674">Nauru (+674)</option>
                                                <option data-countrycode="NP"@if (isset($userProfile) && $userProfile->countryCode == '977') selected @endif value="977">Nepal (+977)</option>
                                                <option data-countrycode="NL"@if (isset($userProfile) && $userProfile->countryCode == '31') selected @endif value="31">Netherlands (+31)</option>
                                                <option data-countrycode="NC"@if (isset($userProfile) && $userProfile->countryCode == '687') selected @endif value="687">New Caledonia (+687)</option>
                                                <option data-countrycode="NZ"@if (isset($userProfile) && $userProfile->countryCode == '64') selected @endif value="64">New Zealand (+64)</option>
                                                <option data-countrycode="NI"@if (isset($userProfile) && $userProfile->countryCode == '505') selected @endif value="505">Nicaragua (+505)</option>
                                                <option data-countrycode="NE"@if (isset($userProfile) && $userProfile->countryCode == '227') selected @endif value="227">Niger (+227)</option>
                                                <option data-countrycode="NG"@if (isset($userProfile) && $userProfile->countryCode == '234') selected @endif value="234">Nigeria (+234)</option>
                                                <option data-countrycode="NU"@if (isset($userProfile) && $userProfile->countryCode == '683') selected @endif value="683">Niue (+683)</option>
                                                <option data-countrycode="NF"@if (isset($userProfile) && $userProfile->countryCode == '672') selected @endif value="672">Norfolk Islands (+672)
                                                </option>
                                                <option data-countrycode="NP" @if (isset($userProfile) && $userProfile->countryCode == '670') selected @endif value="670">Northern Marianas (+670)
                                                </option>
                                                <option data-countrycode="NO"@if (isset($userProfile) && $userProfile->countryCode == '47') selected @endif value="47">Norway (+47)</option>
                                                <option data-countrycode="OM"@if (isset($userProfile) && $userProfile->countryCode == '968') selected @endif value="968">Oman (+968)</option>
                                                <option data-countrycode="PW"@if (isset($userProfile) && $userProfile->countryCode == '680') selected @endif value="680">Palau (+680)</option>
                                                <option data-countrycode="PA"@if (isset($userProfile) && $userProfile->countryCode == '507') selected @endif value="507">Panama (+507)</option>
                                                <option data-countrycode="PG"@if (isset($userProfile) && $userProfile->countryCode == '675') selected @endif value="675">Papua New Guinea (+675)
                                                </option>
                                                <option data-countrycode="PE"@if (isset($userProfile) && $userProfile->countryCode == '51') selected @endif value="51">Peru (+51)</option>
                                                <option data-countrycode="PH"@if (isset($userProfile) && $userProfile->countryCode == '63') selected @endif value="63">Philippines (+63)</option>
                                                <option data-countrycode="PY"@if (isset($userProfile) && $userProfile->countryCode == '595') selected @endif value="595">Paraguay (+595)</option>
                                                <option data-countrycode="PL"@if (isset($userProfile) && $userProfile->countryCode == '48') selected @endif value="48">Poland (+48)</option>
                                                <option data-countrycode="PT"@if (isset($userProfile) && $userProfile->countryCode == '351') selected @endif value="351">Portugal (+351)</option>
                                                <option data-countrycode="PR"@if (isset($userProfile) && $userProfile->countryCode == '1787') selected @endif value="1787">Puerto Rico (+1787)</option>
                                                <option data-countrycode="QA"@if (isset($userProfile) && $userProfile->countryCode == '974') selected @endif value="974">Qatar (+974)</option>
                                                <option data-countrycode="RE"@if (isset($userProfile) && $userProfile->countryCode == '262') selected @endif value="262">Reunion (+262)</option>
                                                <option data-countrycode="RO"@if (isset($userProfile) && $userProfile->countryCode == '40') selected @endif value="40">Romania (+40)</option>
                                                <option data-countrycode="RU"@if (isset($userProfile) && $userProfile->countryCode == '7') selected @endif value="7">Russia (+7)</option>
                                                <option data-countrycode="RW"@if (isset($userProfile) && $userProfile->countryCode == '250') selected @endif value="250">Rwanda (+250)</option>
                                                <option data-countrycode="SM"@if (isset($userProfile) && $userProfile->countryCode == '378') selected @endif value="378">San Marino (+378)</option>
                                                <option data-countrycode="ST"@if (isset($userProfile) && $userProfile->countryCode == '239') selected @endif value="239">Sao Tome &amp; Principe
                                                    (+239)</option>
                                                <option data-countrycode="SA"@if (isset($userProfile) && $userProfile->countryCode == '966') selected @endif value="966">Saudi Arabia (+966)</option>
                                                <option data-countrycode="SN"@if (isset($userProfile) && $userProfile->countryCode == '221') selected @endif value="221">Senegal (+221)</option>
                                                <option data-countrycode="CS"@if (isset($userProfile) && $userProfile->countryCode == '381') selected @endif value="381">Serbia (+381)</option>
                                                <option data-countrycode="SC"@if (isset($userProfile) && $userProfile->countryCode == '248') selected @endif value="248">Seychelles (+248)</option>
                                                <option data-countrycode="SL"@if (isset($userProfile) && $userProfile->countryCode == '232') selected @endif value="232">Sierra Leone (+232)</option>
                                                <option data-countrycode="SG"@if (isset($userProfile) && $userProfile->countryCode == '65') selected @endif value="65">Singapore (+65)</option>
                                                <option data-countrycode="SK"@if (isset($userProfile) && $userProfile->countryCode == '421') selected @endif value="421">Slovak Republic (+421)
                                                </option>
                                                <option data-countrycode="SI"@if (isset($userProfile) && $userProfile->countryCode == '386') selected @endif value="386">Slovenia (+386)</option>
                                                <option data-countrycode="SB"@if (isset($userProfile) && $userProfile->countryCode == '677') selected @endif value="677">Solomon Islands (+677)
                                                </option>
                                                <option data-countrycode="ZA"@if (isset($userProfile) && $userProfile->countryCode == '27') selected @endif value="27">South Africa (+27)</option>
                                                <option data-countrycode="SO"@if (isset($userProfile) && $userProfile->countryCode == '252') selected @endif value="252">Somalia (+252)</option>
                                                <option data-countrycode="ES"@if (isset($userProfile) && $userProfile->countryCode == '34') selected @endif value="34">Spain (+34)</option>
                                                <option data-countrycode="LK"@if (isset($userProfile) && $userProfile->countryCode == '94') selected @endif value="94">Sri Lanka (+94)</option>
                                                <option data-countrycode="SH"@if (isset($userProfile) && $userProfile->countryCode == '290') selected @endif value="290">St. Helena (+290)</option>
                                                <option data-countrycode="KN"@if (isset($userProfile) && $userProfile->countryCode == '1869') selected @endif value="1869">St. Kitts (+1869)</option>
                                                <option data-countrycode="SC"@if (isset($userProfile) && $userProfile->countryCode == '1758') selected @endif value="1758">St. Lucia (+1758)</option>
                                                <option data-countrycode="SD"@if (isset($userProfile) && $userProfile->countryCode == '249') selected @endif value="249">Sudan (+249)</option>
                                                <option data-countrycode="SR"@if (isset($userProfile) && $userProfile->countryCode == '597') selected @endif value="597">Suriname (+597)</option>
                                                <option data-countrycode="SZ"@if (isset($userProfile) && $userProfile->countryCode == '268') selected @endif value="268">Swaziland (+268)</option>
                                                <option data-countrycode="SE"@if (isset($userProfile) && $userProfile->countryCode == '46') selected @endif value="46">Sweden (+46)</option>
                                                <option data-countrycode="CH"@if (isset($userProfile) && $userProfile->countryCode == '41') selected @endif value="41">Switzerland (+41)</option>
                                                <option data-countrycode="SI"@if (isset($userProfile) && $userProfile->countryCode == '963') selected @endif value="963">Syria (+963)</option>
                                                <option data-countrycode="TW"@if (isset($userProfile) && $userProfile->countryCode == '886') selected @endif value="886">Taiwan (+886)</option>
                                                <option data-countrycode="TJ"@if (isset($userProfile) && $userProfile->countryCode == '7') selected @endif value="7">Tajikstan (+7)</option>
                                                <option data-countrycode="TH"@if (isset($userProfile) && $userProfile->countryCode == '66') selected @endif value="66">Thailand (+66)</option>
                                                <option data-countrycode="TG"@if (isset($userProfile) && $userProfile->countryCode == '228') selected @endif value="228">Togo (+228)</option>
                                                <option data-countrycode="TO"@if (isset($userProfile) && $userProfile->countryCode == '676') selected @endif value="676">Tonga (+676)</option>
                                                <option data-countrycode="TT"@if (isset($userProfile) && $userProfile->countryCode == '1868') selected @endif value="1868">Trinidad &amp; Tobago (+1868)
                                                </option>
                                                <option data-countrycode="TN"@if (isset($userProfile) && $userProfile->countryCode == '216') selected @endif value="216">Tunisia (+216)</option>
                                                <option data-countrycode="TR"@if (isset($userProfile) && $userProfile->countryCode == '90') selected @endif value="90">Turkey (+90)</option>
                                                <option data-countrycode="TM"@if (isset($userProfile) && $userProfile->countryCode == '7') selected @endif value="7">Turkmenistan (+7)</option>
                                                <option data-countrycode="TM"@if (isset($userProfile) && $userProfile->countryCode == '993') selected @endif value="993">Turkmenistan (+993)</option>
                                                <option data-countrycode="TC"@if (isset($userProfile) && $userProfile->countryCode == '1649') selected @endif value="1649">Turks &amp; Caicos Islands
                                                    (+1649)</option>
                                                <option data-countrycode="TV"@if (isset($userProfile) && $userProfile->countryCode == '688') selected @endif value="688">Tuvalu (+688)</option>
                                                <option data-countrycode="UG"@if (isset($userProfile) && $userProfile->countryCode == '256') selected @endif value="256">Uganda (+256)</option>
                                                <!-- <option data-countryCode="GB" value="44">UK (+44)</option> -->
                                                <option data-countrycode="UA"@if (isset($userProfile) && $userProfile->countryCode == '380') selected @endif value="380">Ukraine (+380)</option>
                                                <option data-countrycode="AE"@if (isset($userProfile) && $userProfile->countryCode == '971') selected @endif value="971">United Arab Emirates (+971)
                                                </option>
                                                <option data-countrycode="UY" @if (isset($userProfile) && $userProfile->countryCode == '598') selected @endif value="598">Uruguay (+598)</option>
                                                <!-- <option data-countryCode="US" value="1">USA (+1)</option> -->
                                                <option data-countrycode="UZ"@if (isset($userProfile) && $userProfile->countryCode == '7') selected @endif value="7">Uzbekistan (+7)</option>
                                                <option data-countrycode="VU"@if (isset($userProfile) && $userProfile->countryCode == '678') selected @endif value="678">Vanuatu (+678)</option>
                                                <option data-countrycode="VA"@if (isset($userProfile) && $userProfile->countryCode == '379') selected @endif value="379">Vatican City (+379)</option>
                                                <option data-countrycode="VE"@if (isset($userProfile) && $userProfile->countryCode == '58') selected @endif value="58">Venezuela (+58)</option>
                                                <option data-countrycode="VN"@if (isset($userProfile) && $userProfile->countryCode == '84') selected @endif value="84">Vietnam (+84)</option>
                                                <option data-countrycode="VG"@if (isset($userProfile) && $userProfile->countryCode == '84') selected @endif value="84">Virgin Islands - British
                                                    (+1284)</option>
                                                <option data-countrycode="VI" @if (isset($userProfile) && $userProfile->countryCode == '84') selected @endif value="84">Virgin Islands - US (+1340)
                                                </option>
                                                <option data-countrycode="WF"@if (isset($userProfile) && $userProfile->countryCode == '681') selected @endif value="681">Wallis &amp; Futuna (+681)
                                                </option>
                                                <option data-countrycode="YE"@if (isset($userProfile) && $userProfile->countryCode == '969') selected @endif value="969">Yemen (North)(+969)</option>
                                                <option data-countrycode="YE"@if (isset($userProfile) && $userProfile->countryCode == '967') selected @endif value="967">Yemen (South)(+967)</option>
                                                <option data-countrycode="ZM"@if (isset($userProfile) && $userProfile->countryCode == '260') selected @endif value="260">Zambia (+260)</option>
                                                <option data-countrycode="ZW"@if (isset($userProfile) && $userProfile->countryCode == '263') selected @endif value="263">Zimbabwe (+263)</option>
                                            </optgroup>
                                        </select>
                                        @error('countryCode')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                            <input type="text" class="form-control" name="mobile_no"
                                                placeholder="Mobile number" value="{{ old('mobile_no',$userProfile->mobile_no) }}">
                                            <br />
                                            @error('mobile_no')
                                                <span style="color:red;"><b>{{ $message }}</b></span>
                                            @enderror
                                            <span id="mobile_status" style="color:red; font-size:14px"></span>
                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label class="form-label" for="exampleInputEmail"><b>Email-ID
                                            </b>&nbsp;<span style="color:red;">*</span></label>
                                        <input type="email" name="email" class="form-control"
                                            id="exampleInputEmail" placeholder="Enter email" value="{{ old('email',$userProfile->email) }}">
                                        @error('email')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date_of_birth"><b>Date Of Birth</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="date" name="date_of_birth" class="form-control"
                                            id="date_of_birth"  value="{{ old('date_of_birth',$userProfile->date_of_birth) }}" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="gender"><b>Gender
                                            </b>&nbsp;<span style="color:red;">*</span></label>
                                        <select name="gender" class="form-control" id="">
                                            <option value="">Please Select</option>
                                            <option value="male" @if(isset($userProfile->gender)&& $userProfile->gender=='male') selected @endif>Male</option>
                                            <option value="female"  @if(isset($userProfile->gender)&& $userProfile->gender=='female') selected @endif>Female</option>
                                            <option value="prefernottosay"  @if(isset($userProfile->gender)&& $userProfile->gender=='prefernottosay') selected @endif>Prefer not to say
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span style="color:red;"><b>{{ $message }}</b></span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="current_location"><b>Current Location</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="text" name="current_location" class="form-control"
                                            id="current_location" value="{{ old('current_location',$userProfile->current_location) }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="choose_language"><b>Choose Language</b>&nbsp;<span
                                            style="color:red;">*
                                    </label>
                                    <select name="choose_language" class="form-control">

                                        <option value="videos/sample_video_english.mp4" @if((isset($userProfile->choose_language)&& $userProfile->choose_language=='videos/sample_video_english.mp4')) selected @endif>Intro in English
                                        </option>
                                        <option value="videos/sample_video_hindi.mp4" @if((isset($userProfile->choose_language)&& $userProfile->choose_language=='videos/sample_video_hindi.mp4')) selected @endif>Intro in Hindi
                                        </option>
                                    </select>
                                    @error('choose_language')
                                        <span style="color:red;"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                        
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="intro_video_link"><b>Intro Video </b>&nbsp;<span
                                            style="color:red;" >*
                                    </label>
                                    <input type="text" name="intro_video_link" class="form-control"
                                        id="intro_video_link"   value="{{ old('intro_video_link',$userProfile->intro_video_link) }}"/>

                                    @error('intro_video_link')
                                        <span style="color:red;"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="reels_1"><b>Work reel 1</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="text" name="reels_1" class="form-control" id="reels_1"  value="{{ old('reels_1',$userProfile->work_reel1) }}">
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                              
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="reels_2"><b>Work reel 2 </b>&nbsp;<span
                                            style="color:red;">*
                                    </label>
                                    <input type="text" name="reels_2" class="form-control" id="reels_2"  value="{{ old('reels_2',$userProfile->work_reel2) }}" />

                                    @error('reels_2')
                                        <span style="color:red;"><b>{{ $message }}</b></span>
                                    @enderror
                                </div>
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="reels_3"><b>Work reel 3</b>&nbsp;<span
                                                style="color:red;">*
                                            </span></label>
                                        <input type="text" name="reels_3" class="form-control" id="reels_3"  value="{{ old('reels_3',$userProfile->work_reel3) }}">
                                    </div>
                                </div>
                            </div>
                             
                            <div class="row">
                                 
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="status"><b>Image</b>&nbsp;<span
                                            style="color:red;">*
                                    </label>
                                    <br />
                                    <input type="file" name="headshot_image[]" 
                                     id="headshot_image" multiple="multiple" class="form-control"
                                     accept="image/*"
                                     />
                                     @if(isset($userImage->images))
                                  
                                     @foreach ( $userImage->images as $image)
                                       
                                           <img src="{{ asset('upload/profile/'.$image->profile_images) }}" alt=" " width="100" height="100"/> 
                                         
                                           <a class="delete-btn" href="{{ route('') }}">Remove</a>
                                     @endforeach
                                 
                                   @endif
                                   
                                </div>
                               
                                <div class="col-md-6 col-lg-6 col-sm-6">
                                    <label class="form-label" for="status"><b>Status</b>&nbsp;<span
                                            style="color:red;">*
                                    </label>
                                    <br />
                                    <input type="checkbox" name="status" value="1"
                                     id="status" 
                                        @if($userProfile->status == 1)  checked   @endif
                                     />


                                </div>
                            </div>
                           
                            <center>
                                <input type="submit" class="btn btn-success" value="Update" />
                            </center>
                        </form>
                    </div>
                </div>
            </div>

        </div>



        <script src="{{ asset('assets/auth/jquery-3.6.0.js') }}"></script>

    </section>
@endsection
