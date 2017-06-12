
<style>
	.title p{text-align: center; margin:20px 0;}
	.title strong{color:white;background-color:#333; border-radius: 5px; padding:5px 10px; font-size:30px;text-align: center;}
	.patient-info {max-width: 920px;}
	.patient-info p{margin-bottom:2px;}
	.patient-info .col-md-4 p{display:inline-flex;align-items:baseline;width:auto;}
	.patient-info .col-md-4,.col-md-8 {padding:0px;}
	.patient-info .col-md-8 p{width:100%;display:inline;align-items:baseline;text-align: center;}
	.patient-info input{width:50%;border: 0;border-bottom: 1px solid #000;outline: 0;margin-left: 10px;}
	.patient-info .name {text-align: center;}
	.patient-info .name p{width: 100%;justify-content: center;}
	.patient-info .name input{width: 100%;}

	.minors-info i{}
	.minors-info p{margin-bottom: 2px;}
	.minors-info input{width:50%;}

	.medical-history input{width:65% !important;}
	.questions ol{padding:0;margin-top:10px;}
	.questions {max-width: 920px;}
	.questions p{margin-bottom: 2px;align-items:baseline;}
	.questions input{width:30%;border: 0;border-bottom: 1px solid #000;outline: 0;margin-left: 10px;}
	.questions span{margin:0 5px;float:right;}
	.questions .col-md-4 p{width:100%;display:inline-flex;align-items:baseline;}
	.check input{width:20px;border:0; outline:0;margin:0;}
	.signature {padding-top: 40px;}
	.signature input{width:100%;}
	.signature p{justify-content: center;}
	.name .col-md-4 {display: table;}
	.container {font-size: 12px;}
	.input-side-right {width: 200px !important;}
	.span-no {padding-right: 100px;}
	.question-li {position: relative !important;top: -13px !important;}
	.table-ordered {border:1px solid #ddd;position:absolute;width:100%;left:-20px;top:150px;}
	.table-ordered td {border:1px solid #ddd;text-align: center;}
	.table-ordered th {border:1px solid #ddd;}
	.tbl-dental-history {font-size: 12px;}
	

</style>
<style type="text/css">
.no-pad {position: relative; padding: 0 25px;}
.no-pad div{padding: 0; text-align: center; }
.bordered { border-right: 1px solid #ddd }
.dental-chart{ padding:50px 0;  }
.dental-chart input{ width:35px;  }
.dental-chart .row{ margin-bottom: 20px;  }
.dental-chart h5{ position: absolute; }
.pos1 {top:0; left: 0px;}
.pos2 {top:0; right:0px;}
.pos3 {bottom:0; left: 0px;}
.pos4 {bottom:0; right:0px;}
#dental-canvas-view {
  height: 104%;
  left: 0;
  position: relative;
  top: -2px;
  width: 100%;
}
.color-result {
  background-color: red;
  height: 58px;
  margin-left: 73px;
  position: relative;
  width: 64px;
}
.dental-color {
  border: 1px solid;
  height: 33px;
  width: 40px;
}
.dental-color-container {
  float: left;
  margin-bottom: 6px;
  padding: 0;
  width: 72px;
}
.dental-color {
  border: 0 none;
  float: left;
  height: 28px;
  margin-right: 8px;
  width: 28px;
  border-radius: 0;
}
.dental-color :hover
{
	cursor: pointer;
}
.dental-icon {
  background-color: red;
  float: left;
  height: 29px;
  margin-right: 5px;
  position: relative;
  right: 2px;
  width: 30px;
}
.dental-icon :hover
{
	cursor: pointer;
}
.color-red{
	background-color: red;
}
.color-blue{
	background-color: blue;
}
.color-yellow{
	background-color: yellow;
}
.color-orange{
	background-color: orange;
}
.color-green{
	background-color: green;
}
.color-black{
	background-color: black;
}
.color-brown{
	background-color: brown;
}
.dental-icon > img {
  position: relative;
  top: -1px;
}
.dental-canvas {
  height: 118%;
  position: relative;
  right: 1px;
  top: -1px;
  width: 115%;
}
.dental-color.dental-btn-clear.btn {
  border: 1px solid;
}
.dental-color.dental-btn-clear.btn > p {
  font-size: 11px;
  position: relative;
  right: 11px;
}
.canvas-tooth {
  height: 37px;
  width: 39px;
}
.custom-form-group {
  position: relative;
  top: 11px;
}
</style>
<style>
.treatment-code-desc{ font-weight: 700; cursor: pointer; }
</style>
<style>
		p {margin:5px 0;}
		.informed-consent {width:920px;}
		.informed-consent .row p strong{text-decoration: underline;font-size: 16px;}

		.title {margin:40px 0 20px 0;}
		.title p{text-align: center;}
		.title strong{text-decoration:none !important;color:white;background-color:#333; border-radius: 5px; padding:5px 10px; font-size:30px;text-align: center;}

		.initial {float: right;}
		.initial input{width:60px;border: 0; border-bottom: 1px solid #000;outline: 0;margin:0 2px;}

		.span-style-1 {text-decoration: underline;}

		.notice p{text-align: center;text-decoration: underline;}

		.signature {margin:10px;}
		.signature input{width:80%;border: 0;border-bottom: 1px solid #000;outline: 0;}
		.signature p{justify-content: center;text-align: center;}
	</style>
<?php if($pir) { ?>
<div class="container patient-info" style="">

		<div class="row title" style="position:relative;top:-3px;">
			<p><strong>PATIENT INFORMATION RECORD</strong></p>
		</div>
		
		<div class="row"><br/><br/><br/>
		<div style="width:180px;position:absolute;top:-20px;">
			<?php if($patient->image != null && $patient->image != ''){ ?>
				<?php $img=explode('/', $patient->image) ?>
				<?php 
					$str_img="";
					foreach ($img as $key => $val) {
						if($key > 1)
						{
							$str_img.='/'.$val;
						}
						
					}

					
				?>
				<img src="<?= ROOT.$str_img; ?>"  style="height:135px;width:140px;"/>
			<?php }else { ?>
				<img src="#" style="height:135px;box-shadow: inset 0px 21px 1px rgba(0,0,0,0.5);width:140px;" />
			<?php } ?>

		</div>
		<h3><strong>PROFILE</strong></h3>
		</div>
		<div class="row name" style="margin-bottom:60px;text-align:center;padding-left:50px;top:-15px;position:relative;">
			<div class="col-md-4" style="position:absolute;">
				<p>Name:<input type="" name="" style="width:200px;text-align:center;" value="<?php echo $patient->lastname; ?>"></p>
				<p>Last</p>
			</div>
			<div class="col-md-4" style="position:absolute;left:320px;">
				<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->firstname; ?>"></p>
				<p>First</p>
			</div>
			<div class="col-md-4" style="position:absolute;left:550px;">
				<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->middlename; ?>"></p>
				<p>Middle</p>
			</div>
		</div>
		<div class="row" style="padding-left:50px;">
			<div class="col-md-4"  style="float:left;">
				<table  class="tbl-dental-history">
					<tr>
						<td style="text-align:right;">Age:</td>
						<td><input type="" name=" "    style="width:150px;" value="<?php echo $patient->age; ?>"></td>
					</tr>
					<tr>
						<td style="text-align:right;">Birthdate(mm/dd/yy):</td>
						<td ><input type="" name=""  style="width:150px;" value="<?= ($patient->birthdate != "" ? date("F d, Y", strtotime($patient->birthdate)) : ""); ?>"></td>
					</tr>
					<tr>
						<td style="text-align:right;">Home Address:</td>
						<td ><input type="" name="" style="width:150px;" value="<?php echo $patient->address.' '.$patient->city.','.$patient->province; ?>"></td>
					</tr>
					<tr>
						<td style="text-align:right;">Occupation:</td>
						<td ><input type="" name="" style="width:150px;" value="<?php echo $patient->occupation; ?>"></td>
					</tr>
					<tr>
						<td style="text-align:right;">Company:</td>
						<td ><input type="" name="" style="width:150px;" value="<?php echo $patient->company; ?>"></td>
					</tr>
					<!-- <tr>
						<td style="text-align:right;">Civil Status:</td>
						<td ><input type="" name="" style="width:150px;" value="<?php echo $patient->civil_status; ?>"></td>
					</tr>
					<tr>
						<td style="text-align:right;">Gender:</td>
						<td ><input type="" name="" style="width:150px;" value="<?php echo $patient->gender; ?>"></td>
					</tr> -->
				</table>
			</div>
			<div class="col-md-4" style="text-align:right;right:200px;position:absolute;">

				Civil Status:<input type="" class="input-side-right" name="" value="<?php echo $patient->civil_status; ?>"><br/>
				Gender:<input type="" name="" class="input-side-right" value="<?php echo $patient->gender; ?>"><br/>
				Telephone No.:<input type="" name="" class="input-side-right" value="<?php echo $patient->telephone_number; ?>"><br/>
				Mobile No.:<input type="" name="" class="input-side-right" value="<?php echo $patient->mobile_number; ?>"><br/>
				Health Card Type:<input type="" name="" class="input-side-right" value="<?php echo $patient->health_card_type; ?>"><br/>
				Health Card No.:<input type="" name="" class="input-side-right" value="<?php echo $patient->health_card_number; ?>"><br/>
			</div>
		</div>
		<br/><br/><br/><br/><br/><br/><br/><br/>
		<div class="row">
			<div class="row">
				<div class="col-md-12">
					<h3><strong>DENTAL HISTORY</strong></h3>
					<table class="tbl-dental-history" style="top:-15px;position:relative;">
					
						<tr>
							<td style="text-align:right;">Reason For Visit:</td><td style="width:300px;"><input  value="<?php echo $patient->visit_reason; ?>" /></td>
							<td style="text-align:right;">Date of Last Dental X-ray:</td><td style="width:300px;"><input  value="<?php echo $patient->last_dental_xray; ?>" /></td>
						</tr>
						<tr>
							<td style="text-align:right;">Former Dentist:</td><td style="width:300px;"><input  value="<?php echo $patient->former_dentist; ?>" /></td>
							<td style="text-align:right;">How often do you floss?:</td><td style="width:300px;"><input  value="<?php echo $patient->often_floss; ?>" /></td>
						</tr>
						<tr>
							<td style="text-align:right;">Address:</td><td style="width:300px;"><input  value="<?php echo $patient->dentist_address; ?>" /></td>
							<td style="text-align:right;">How often do you brush?:</td><td style="width:300px;"><input  value="<?php echo $patient->often_brush; ?>" /></td>
						</tr>
						<tr>
							<td style="text-align:right;">Date of Last Dental Care:</td><td style="width:300px;"><input  value="<?php echo $patient->last_dental_care; ?>" /></td>
						</tr>
					</table><br/>
					<table class="tbl-dental-history">
					
						<tr>
							<td><input type="checkbox"  <?= (in_array('Bad breath',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bad breath</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Grinding Teeth',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grinding Teeth</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Sensitivity to hot',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sensitivity to hot</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Bleeding gums',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bleeding gums</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Loose teeth or broken fillings',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Loose teeth or broken fillings</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Sensitivity to sweets',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sensitivity to sweets</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Clicking of popping jaw',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clicking of popping jaw</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Periodontal treatment',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Periodontal treatment</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Sensitivity on biting',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sensitivity on biting</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Food collection between teeth',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Food collection between teeth</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Sensitivity to cold',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sensitivity to cold</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Sores or growths in your mouth',$a_other_dental_history) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sores or growths in your mouth</td>
							
						</tr>
						
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<h3><strong>MEDICAL HISTORY</strong></h3>
					<table  class="tbl-dental-history" style="top:-15px;position:relative;">
						<tr>
							<td style="width:150px;text-align:right;">Date:</td><td><input   value="<?php echo $patient->medical_date; ?>" /></td>
							<td style="width:150px;text-align:right;">Are you good in health?:</td><td><input   value="<?php echo $patient->is_in_good_health == false? 'No':$patient->is_in_good_health; ?>" /></td>
							
						</tr>
						<tr>
							<td style="width:150px;text-align:right;">Have there been changes in your general health in the past year?:</td><td><input   value="<?php echo $patient->has_general_health_changes == false? 'No':$patient->has_general_health_changes; ?>" /></td>
							<td style="width:150px;text-align:right;">Are you taking medications, non-prescription drugs or herbal supplements of any kind?:</td><td><input   value="<?php echo $patient->is_taking_medications == false? 'No':$patient->is_taking_medications; ?>" /></td>
							
						</tr>
						<tr>
							<td style="width:150px;text-align:right;">When were your last medical checkup?:</td><td><input   value="<?php echo $patient->last_checkup; ?>" /></td>
							<td style="width:150px;text-align:right;">Do you smoke?:</td><td><input   value="<?php echo $patient->is_smoker == false? 'No':$patient->is_smoker; ?>" /></td>
						</tr>
					</table>
					<h4>Are you allergic or reaction to:</h4>
					<table class="tbl-dental-history" style="top:-15px;position:relative;">
					
						<tr>
							<td><input type="checkbox"  <?= (in_array('Latex Allergy',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Latex Allergy</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Aspirin',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aspirin</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Local Anesthetic',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Local Anesthetic</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Iodine',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Iodine</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Penicillin or other anitibiotics',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Penicillin or other anitibiotics</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Codeine or other narcotics',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Codeine or other narcotics</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Sulfa Drugs',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sulfa Drugs</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Barbiturates, Sedatives or sleeping pills',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Barbiturates, Sedatives or sleeping pills</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Other',$allergies) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other</td>
							
						</tr>
						
					</table>
					<h4>Do you have or had any of the following diseases or problems:</h4>
					<table class="tbl-dental-history" style="top:-15px;position:relative;">
					
						<tr>
							<td><input type="checkbox"  <?= (in_array('Damage or Artificial heart valves',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td style="width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Damage or Artificial heart valves</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Thyroid Problems',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td style="width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thyroid Problems</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Rheumatic Heart Disease',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td style="width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rheumatic Heart Disease</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Repiratory problems, emphysema, bronchitis',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td style="padding-left:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Repiratory problems, emphysema, bronchitis</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Cardiovascular Disease',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cardiovascular Disease</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Arthritis',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Arthritis</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('High Blood Pressure',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;High Blood Pressure</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Stomach ulcer, or hyperacidity',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stomach ulcer, or hyperacidity</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Chest pain upon exertion',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chest pain upon exertion</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Kidney troubles',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kidney troubles</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Shortness of breath after mild exercise or when lying down',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td style="padding-left:10px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Shortness of breath after mild exercise or when lying down</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Tuberculosis',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tuberculosis</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Inborn heart defects',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inborn heart defects</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Low blood pressure',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Low blood pressure</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Cardiac pacemaker',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cardiac pacemaker</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Sexually Transmitted disease',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sexually Transmitted disease</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Seasonal Allergies',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seasonal Allergies</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Epilepsy',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Epilepsy</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Sinus',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sinus</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Cancer',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cancer</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Asthma or hayfever',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Asthma or hayfever</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Immune System Problem',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Immune System Problem</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Fainting or Seizures',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Fainting or Seizures</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Abnormal bleeding',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Abnormal bleeding</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Persistent diarrhea or weight loss',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Persistent diarrhea or weight loss</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Blood transfusion',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Blood transfusion</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Diabetes',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Diabetes</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('Anemia',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Anemia</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Hepatitis, Jaundice or liver disease',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hepatitis, Jaundice or liver disease</td>
							<td style="padding-left:100px;"><input type="checkbox"  <?= (in_array('Tumor or growth',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tumor or growth</td>
							
						</tr>
						<tr>
							<td><input type="checkbox"  <?= (in_array('AIDS or HIV Infection',$diseases) == true ? 'checked="true"' : ''); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;AIDS or HIV Infection</td>							
						</tr>
						
					</table>
					<h4 style="top:-15px;position:relative;">Woman:</h4>
					<table class="tbl-dental-history" style="top:-15px;position:relative;">
					
						<tr>
							<td><input type="checkbox" <?= ($patient->is_pregnant == "1" ? "checked='true'" : ""); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Are you pregnant?</td>
							<td><input type="checkbox"  <?= ($patient->is_nursing == "1" ? "checked='true'" : ""); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Are you nursing?</td>
							<td><input type="checkbox"  <?= ($patient->is_taking_pills == "1" ? "checked='true'" : ""); ?> /></td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Are you taking birth control?</td>
				
							
						</tr>
						
					</table>
				</div>
			</div>
		</div>
</div>
<?php } ?>

<?php if($drc){ ?>

	<?php if($pir) { ?>
		<br/><br/>
	<?php } ?>

<?php //$dn = get_diagram_notation($diagram_notation,"A_UL"); ?>
<div class="container patient-info" style="">
	<div class="row name" style="margin-bottom:60px;text-align:center;padding-left:50px;top:-15px;position:relative;">
		<div class="col-md-4" style="position:absolute;">
			<p>Name:<input type="" name="" style="width:200px;text-align:center;" value="<?php echo $patient->lastname; ?>"></p>
			<p>Last</p>
		</div>
		<div class="col-md-4" style="position:absolute;left:320px;">
			<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->firstname; ?>"></p>
			<p>First</p>
		</div>
		<div class="col-md-4" style="position:absolute;left:550px;">
			<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->middlename; ?>"></p>
			<p>Middle</p>
		</div>
	</div>
</div><br/><br/>
<div class="row title" style="position:relative;right:30px;">
			<p style="font-size:500px;"><strong>DENTAL RECORD CHART</strong></p>
		</div>
<?php $count=0; ?>
	<?php foreach ($patient_chart as $dental_chart_details) { ?>
		<?php if($count == 0){ ?>
		<div class="container">
				<div class="dental-chart" style="margin-bottom:400px;margin-right:50px;">
					<div class="row">
						<div class="col-xs-6 no-pad bordered" style="float:left;left:30px;">
							<div class="row">
								<!-- 1st LAYER UPPER LEFT -->
								<h5 class="pos1"> RIGHT </h5> 
								<table style="position:relative;left:130px;">
									<tr>
								<?php
									$dn = get_diagram_notation($diagram_notation,"C_UR");

									foreach($dn as $i => $label) {

								?>
									<td>
									<?php if($i == 0){ ?>
									<div class="col-xs-offset-7 col-xs-1">
									<?php }else{ ?>
									<div class="col-xs-1">
									<?php } ?>
									
									<?php if(!empty($dental_chart_details[$i])) { ?>
										<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<p><?php echo $label; ?></p>
										<a href="javascript:chart(<?php echo $i; ?>,'Upper','Right','First')" >
										<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
											<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
											</div>
										</a>
									<?php }else { ?>

										<input type="text" name="">
										<p><?php echo $label; ?></p>
										<a href="javascript:chart(<?php echo $i; ?>,'Upper','Right','First')" >
											<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>" data-if-line='false' data-if-x='false' data-this-color="red">
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
											</div>
										</a>
									<?php } ?>
										
									</div>
									</td>
								<?php } ?>
									</tr>
								</table>
								
							</div>
							<?php $dn = get_diagram_notation($diagram_notation,"A_UR"); ?>
							<div class="row">
								<!-- 2nd LAYER UPPER LEFT -->
								<table>
									<tr>
								<?php $count=0; ?>
								<?php foreach ($dn as $i => $label){ ?>
									<td>
									<?php if($count == 0){ ?>
									<div class="col-xs-offset-4 col-xs-1">
									<?php }else{ ?>
									<div class="col-xs-1">
									<?php } ?>
										<?php if(!empty($dental_chart_details[$i])) { ?>
										<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<p><?php echo 18-$count; ?></p>
										<a href="javascript:chart(<?php echo 18-$count; ?>,'Upper','Right','Second')" >
										<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
											<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo 18-$count; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo 18-$count; ?>" data-tooth-number="<?php echo 18-$count; ?>"></canvas>
											</div>
										</a>
										<?php }else { ?>
										<input type="text" name="">
										<p><?php echo 18-$count; ?></p>
										<a href="javascript:chart(<?php echo 18-$count; ?>,'Upper','Right','Second')" >
											<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo 18-$count; ?>"  >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo 18-$count; ?>" data-tooth-number="<?php echo 18-$count; ?>"></canvas>
											</div>
										</a>
										<?php } ?>
									</div>
									<?php $count++; ?>
									</td>
								<?php } ?>
									</tr>
								</table>
							</div>	
						</div>
						<div class="col-xs-6 no-pad" style="margin-left:20px;">
							<!-- 1st LAYER UPPER RIGHT -->
							<h5 class="pos2">LEFT</h5>
							<div class="row" style="position:relative;left:50px;">
								<table>
									<tr>
								<?php
									$dn = get_diagram_notation($diagram_notation,"C_UL");

									foreach($dn as $i => $label) {

								?>
									<td>
									<div class="col-xs-1">
										<?php if(!empty($dental_chart_details[$i])) { ?>
										<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<p><?php echo $label; ?></p>
										<a href="javascript:chart(<?php echo $i; ?>,'Upper','Left','First')" >
											<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
											<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
											</div>
										</a>
										<?php }else { ?>
										<input type="text" name="">
										<p><?php echo $label; ?></p>
										<a href="javascript:chart(<?php echo $i; ?>,'Upper','Right','First')" >
											<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>" data-if-line='false' data-if-x='false' data-this-color="red">
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
											</div>
										</a>
										<?php } ?>
									</div>
									</td>
								<?php } ?>
									</tr>
								</table>
								
							</div>
							<!-- 2nd LAYER UPPER RIGHT -->
							<?php $dn = get_diagram_notation($diagram_notation,"A_UL"); ?>
							<div class="row" style="position:relative;left:50px;">	
								<table>
									<tr>	
								<?php $count=0; ?>
								<?php foreach ($dn as $i => $label){ ?>
									<td>
									<div class="col-xs-1">
										<?php if(!empty($dental_chart_details[$i])) { ?>
										<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<p><?php echo 21+$count; ?></p>
										<a href="javascript:chart(<?php echo 21+$count; ?>,'Upper','Left','First')" >
											<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
											<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo 21+$count; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo 21+$count; ?>" data-tooth-number="<?php echo 21+$count; ?>"></canvas>
											</div>
										</a>
										<?php }else { ?>
										<input type="text" name="">
										<p><?php echo 21+$count; ?></p>
										<a href="javascript:chart(<?php echo 21+$count; ?>,'Upper','Left','First')" >
											<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo 21+$count; ?>"  >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo 21+$count; ?>" data-tooth-number="<?php echo 21+$count; ?>"></canvas>
											</div>
										</a>
										<?php } ?>
									</div>

									<?php $count++; ?>
									</td>
								<?php } ?>			
									</tr>
								</table>
							</div>
						</div>
					</div>

					<hr>

					<!--LOWER PART -->
					<?php $dn = get_diagram_notation($diagram_notation,"A_LR"); ?>
					<div class="row">

						<div class="col-xs-6 no-pad bordered" style="float:left;left:30px;">
						<!-- 1st LAYER LOWER LEFT -->
							<h5 class="pos3">RIGHT</h5>
							<div class="row">
								<table>
									<tr>
								<?php $count=0; ?>
								<?php foreach ($dn as $i => $label){ ?>
									<td>
									<?php if($count == 0){ ?>
									<div class="col-xs-offset-4 col-xs-1">
									<?php }else{ ?>
									<div class="col-xs-1">
									<?php } ?>
									<?php if(!empty($dental_chart_details[$i])) { ?>
										<a href="javascript:chart(<?php echo 48-$count; ?>,'Upper','Left','First')" >
											<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
											<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo 48-$count; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo 48-$count; ?>" data-tooth-number="<?php echo 48-$count; ?>"></canvas>
											</div>
										</a>
										<p><?php echo 48-$count; ?></p>
										<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
									<?php }else { ?>
										<a href="javascript:chart(<?php echo 48-$count; ?>,'Upper','Left','First')" >
											<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo 48-$count; ?>"  >
											<div>
												<canvas class="canvas-tooth" id="canvas-for-<?php echo 48-$count; ?>" data-tooth-number="<?php echo 48-$count; ?>"></canvas>
											</div>
										</a>
										<p><?php echo 48-$count; ?></p>
										<input type="text" name="">
									<?php } ?>	
									</div>
									<?php $count++; ?>
									</td>
								<?php } ?>
									</tr>
								</table>
								
							</div>
							<!-- 2nd LAYER LOWER LEFT -->
							<div class="row" style="position:relative;left:130px;">
								<table>
									<tr>
								<?php
									$dn = get_diagram_notation($diagram_notation,"C_LR");

									foreach($dn as $i => $label) {

								?>
									<td>
									<?php if($i == 0){ ?>
									<div class="col-xs-offset-7 col-xs-1">
									<?php }else{ ?>
									<div class="col-xs-1">
									<?php } ?>
										<?php if(!empty($dental_chart_details[$i])) { ?>
											<a href="javascript:chart(<?php echo $i; ?>,'Upper','Left','First')" >
												<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
												<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
												<div>
													<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
												</div>
											</a>
											<p><?php echo $label; ?></p>
											<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<?php }else { ?>
											<a href="javascript:chart(<?php echo $i; ?>,'Upper','Left','First')" >
												<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>"  >
												<div>
													<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
												</div>
											</a>
											<p><?php echo $label; ?></p>
											<input type="text" name="">
										<?php } ?>
									</div>
									</td>
								<?php } ?>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-xs-6 no-pad">

							<h5 class="pos4" style="">LEFT</h5>
							<!-- 1st LAYER LOWER RIGHT -->
							<?php $dn = get_diagram_notation($diagram_notation,"A_LL"); ?>
							<div class="row" style="position:relative;left:50px;">
								<table>
									<tr>
								<?php $count=0; ?>
								<?php foreach ($dn as $i => $label){ ?>
									<td>
									<div class="col-xs-1">
										<?php if(!empty($dental_chart_details[$i])) { ?>
											<a href="javascript:chart(<?php echo 31+$count; ?>,'Upper','Left','First')" >
												<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
											<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo 31+$count; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
												<div>
													<canvas class="canvas-tooth" id="canvas-for-<?php echo 31+$count; ?>" data-tooth-number="<?php echo 31+$count; ?>"></canvas>
												</div>
											</a>
											<p><?php echo 31+$count; ?></p>
											<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<?php }else { ?>
											<a href="javascript:chart(<?php echo 31+$count; ?>,'Upper','Left','First')" >
												<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo 31+$count; ?>"  >
												<div>
													<canvas class="canvas-tooth" id="canvas-for-<?php echo 31+$count; ?>" data-tooth-number="<?php echo 31+$count; ?>"></canvas>
												</div>
											</a>
											<p><?php echo 31+$count; ?></p>
											<input type="text" name="">
										<?php } ?>
									</div>
									<?php $count++; ?>
									</td>
								<?php } ?>
									</tr>
								</table>
							</div>
							<!-- 2nd LAYER LOWER RIGHT -->
							<div class="row" style="position:relative;left:50px;">
								<table>
									<tr>
								<?php
									$dn = get_diagram_notation($diagram_notation,"C_LL");

									foreach($dn as $i => $label) {

								?>
									<td>
									<div class="col-xs-1">
										<?php if(!empty($dental_chart_details[$i])) { ?>
											<a href="javascript:chart(<?php echo $i; ?>,'Upper','Left','First')" >
												<?php $img=explode('/', $dental_chart_details[$i]['image']) ?>
												<img src="<?= ROOT."/webroot/images/chart/".$img[sizeof($img)-1]; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>" data-if-line='<?= ($dental_chart_details[$i]['has_line'] == 1 ? "true" : "false"); ?>' data-if-x='<?= ($dental_chart_details[$i]['has_cross_out'] == 1 ? "true" : "false"); ?>' data-this-color="<?= $dental_chart_details[$i]['color']?>" data-treatment-id='<?= $dental_chart_details[$i]['treatment_id'] ?>' data-note='<?= $dental_chart_details[$i]['note'] ?>' data-doctor-name='<?= $dental_chart_details[$i]['doctor_name']; ?>' >
												<div>
													<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
												</div>
											</a>
											<p><?php echo $label; ?></p>
											<input type="text" name="" value="<?= $dental_chart_details[$i]['treatment_code']; ?>">
										<?php }else { ?>
											<a href="javascript:chart(<?php echo $i; ?>,'Upper','Left','First')" >
												<img src="<?= ROOT."/webroot/images/chart/1.png"; ?>" class="img-tooth" id="chart-icon-<?php echo $i; ?>"  >
												<div>
													<canvas class="canvas-tooth" id="canvas-for-<?php echo $i; ?>" data-tooth-number="<?php echo $i; ?>"></canvas>
												</div>
											</a>
											<p><?php echo $label; ?></p>
											<input type="text" name="">
										<?php } ?>
										
									</div>
									</td>
								<?php } ?>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
		</div>
		<?php } ?>
		<?php $count++; ?>
	<?php } ?>


<?php } ?>


<?php if($ic) { ?>
	<?php if($drc && $pir) { ?>
		
		
	<?php } ?>
	<?php if($drc) { ?>
		<br/><br/><br/><br/>
		<br/><br/><br/><br/>
		<br/><br/>
	<?php } ?>
	
	
	<div class="row title" style="position:relative;right:30px;">
			<p style="font-size:500px;"><strong>INFORMED CONSENT</strong></p>
		</div>
	<div class="container informed-consent">
		
		<div class="row">
			<p><strong>TREATMENT TO BE DONE:</strong>&nbsp;I understand and consent to have any treatment done by the dentist after the procedure, the risks &amp; benefits &amp; cost have been fully explained. These treatments include, but are not limited to x-rays, cleanings, periodontal treatments, fillings, crowns, bridges, all types of extraction, root canals &amp;/or dentures, local anaesthetics &amp; surgical cases.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row">
			<p><strong>DRUGS &amp; MEDICATION:</strong>&nbsp;I understand that antibiotics, analgesics &amp; other medications can cause allergic reactions like redness &amp; swelling of tissues, pain, itching, vomiting, &amp;/or anaphylactic shock.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row">
			<p><strong>CHANGES IN TREATMENT PLAN:</strong>&nbsp;I understand that during treatment it may be necessary to change/add procedures because of conditions found while working on teeth that was not discovered during examination. For example, root canal therapy may be needed following routine restorative procedures. I give my permission to the dentist to make any/all changes and additions as necessary w/ my responsibility to pay all the costs charges.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row">
			<p><strong>RADIOGRAPH:</strong>&nbsp;I understand that an x-ray shot or radiograph maybe necessary as part of diagnostic aid to come up with tentative diagnosis of my Dental problem and to make a good treatment plan but, this will not give me a 100% assurance for the accuracy of the treatment since all dental treatments are subject to unpredictable complications that later on may lead to sudden change of treatment plan and subject to new charges.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row">
			<p><strong>REMOVAL OF TEETH:</strong>&nbsp;I understand that the alternatives to tooth removal (root canal therapy, crowns &amp; periodontal surgery, etc.) &amp; I completely understand these alternatives, including their risk &amp; benefits prior to authorizing the dentist to remove teeth &amp; any other structures necessary for reasons above. I understand that removing teeth does not always remove all the infections, if present, &amp; it may be necessary to have further treatment. I understand the risk involved in having teeth reoved, such as pain, swelling, spread of infection, dry socket, fractured jaw, loss of feeling on teeth, lips, tounge &amp; surrounding tissue that can last for an indefinite period of time. I understand that I may need further treatment under a specilist if complications arise during or following treatment.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row">
			<p><strong>CROWN (CAPS) &amp; BRIDGES:</strong>&nbsp;Preparing a tooth may irritate the nerve tissue in the center of the tooth, leaving the tooth extra sesitive to heat, cold &amp; pressure. Treating such irritation may involve using special toothpastes, mouth rinses of root canal therapy. I understand that sometimes it is not possible to match the color of natural teeth exactly with artificial teeth. I further understand that I may be wearing temporary crowns, which may come off easily &amp; that I must careful to ensure that they are kept on until the permanent crowns are delivered. It is my responsibility to return for permanent cementation within 20 days from tooth preparation, as excessive days delay may allow for tooth movement, which may necessitate a remake of the crown, bridge/cap. I understand that there will be additional charges for remakes due to my delaying of permanent cementation, &amp; I realize that final opportunity to make changes in my new crown, bridges or cap (including shape, fit, size, &amp; color) will be <span class="span-style-1">before</span> permanent cementation<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>
		
		<div class="row">
			<p><strong>ENDODONTICS (ROOT CANAL):</strong>&nbsp;I understand there is no guarantee that a root canal treatment will save a tooth &amp; that complications can occur from the treatment &amp; that occasionally root canal filling materials may extend through the tooth which does not necessarily effect the success of the treatment. I understand that endodontic files &amp; drills are very fine instruments &amp; stresses vented in their manufacture &amp; calcification present in teeth cane cause them to break during use. I understand that referral to the endodontist for additional treatments may be necessary following any root canal treatment &amp; I agree that I am responsible for any additional cost for treatment performed by the endodontist. I undersstand that a tooth may require removal in spite of all efforts to save it.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row">
			<p><strong>PERIODONTAL DISEASE:</strong>&nbsp;I understand that periodontal disease is a serious condition causing gum &amp; bone inflammation &amp;/or loss &amp; that can lead eventually to the loss of my teeth. I understand the alternative treatment plans to correct periodontal disease, including gum surgery tooth extractions with or without replacement. I understand that undertaking any dental procedures may have future adverse effect on my periodontal conditions.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>
			
		<div class="row">
			<p><strong>FILLINGS:</strong>&nbsp;I understand that care must be excercised in chewing on fillings, especially during the first 24 hours to avoid breakage. I understand that a more extensive filling or a crown may be required, as additional decay or fracture may become evident after initial excavation. I understand that significant sensitivity is common, but usually temporary, after-effect or a newly placed filling. I further understand that filling a tooth may irritate the nerve tissue creating sensitivity &amp; treating such sensitivty could require root canal therapy or extractions.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>
		
		<div class="row">
			<p><strong>DENTURES:</strong>&nbsp;I understand that wearing of dentures can be difficult. Sore spots, altered speech &amp; difficulty in eating are common probblems. Immediate dentures (placement of denture immediately after extractions) may be painful. Immediate dentures may require considerable adjusting &amp; several relines. I understand that it is my responsibility to return for delivery of dentures. I understand that failure to keep my delivery appointment may result in poorly fitted dentures. If a remake is required due to my delays of more than 30 days, there will be additional charges. A permanent reline will be needed later, which is not included in the initial fee. I understand that al adjustment or alterations of any kind after this initial period is subject to charges.<span class="initial">(Initial:<input type="" name="">)</span></p>
		</div><br/><br/>

		<div class="row notice">
			<p>I understand that dentistry is not an exact science and that no dentist can properly guarantee accurate results all the time.</p>
		</div><br/>

		<div class="row">
			<p>I hereby authorize any of the doctors/dental auxiliaries to proceed with &amp; perform the dental restorations &amp; treatments as explained to me. I understand that these are subject to modification depending on undiagnosable circumstances that may arise during the course of treatment. I understand that regardless of any dental insurance coverage I may have, I am responsible for payment of dental fees, I agree to pay any attorney's fees, collection fee, or court costs that may be incurred to satisfy any obligation to this office. all treatment were properly explaind to me &amp; any untoward circumstances may arise during the procedure, the attending dentist will not be held liable since it is my free will, with full trust &amp; confidence in him/here, to undergo dental treatment under his/her care.</p>
		</div>

		<div class="row signature">
			<div class="col-md-5" style="float:left;">
				<p><input type="" name="" style="width:200px;margin-left:50px;"></p>
				<p style="margin-left:50px;">Patient/Parent/Guardian Signature</p>
			</div>
			<div class="col-md-4"  style="float:left;"	>
				<p><input type="" name="" style="width:200px;margin-left:50px;"></p>
				<p style="margin-left:50px;">Dentist Signature</p>
			</div>
			<div class="col-md-3"  style="float:left;">
				<p><input type="" name="" style="width:200px;margin-left:50px;"></p>
				<p style="margin-left:50px;">Date</p>
			</div>
		</div>

	</div>

<?php } ?>
<?php if($tr) { ?>
	<?php if($pir && $drc && $ic) { ?>
		<br/><br/>
	<?php }else if($ic){ ?>
		<br/><br/>
	<?php }else if($drc){ ?>
		<?php if($pir){ ?>
			<br/><br/>
		<br/><br/>
		<?php }else { ?>
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<br/><br/>
		<?php } ?>
		
	<?php }else if($pir){ ?>
		
	<?php } ?>

	<div style="margin-bottom:0px;margin-top:0px;margin-left:30px;position:relative;">
		<div class="container patient-info" style="position:relative;">
			<div class="row name" style="margin-bottom:100px;text-align:center;">
				<div class="col-md-4" style="position:absolute;">
					<p>Name:<input type="" name="" style="width:200px;text-align:center;" value="<?php echo $patient->lastname; ?>"></p>
					<p>Last</p>
				</div>
				<div class="col-md-4" style="position:absolute;left:300px;">
					<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->firstname; ?>"></p>
					<p>First</p>
				</div>
				<div class="col-md-4" style="position:absolute;left:560px;">
					<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->middlename; ?>"></p>
					<p>Middle</p>
				</div>
			</div>

		</div>
		<div class="title" style="position:relative;top:60px;margin-right:90px;">
			<p><strong>TREATMENT RECORD</strong></p>
		</div>
		<table class="table table-ordered"> 
			<thead>
				<tr> 
					<th style="width:100px;text-align:center;">Date</th>
					<th style="width:80px;text-align:center;">Tooth No./s</th>
					<th style="width:200px;text-align:center;">Procedure</th>
					<th style="text-align:center;">Dentist</th>
					<th style="width:80px;text-align:center;">Amount Charged</th>
					<th style="width:80px;text-align:center;">Amount Paid</th>
					<th style="width:80px;text-align:center;">Balance</th>
				</tr> 
			</thead> 
			<tbody> 

				<?php foreach ($treatment as $t => $tvalue) { ?>
					<?php if(sizeof($tvalue) <= 1){ ?>
						<tr> 
							<td style="width:80px;"><?= $t; ?></td>
							<td style="width:80px;"><?= $tvalue[0]['tooth']; ?></td>
							<td style="width:200px;"><?= $tvalue[0]['render']; ?></td>
							<td><?= $tvalue[0]['doctor_name']; ?></td>
							<td style="width:80px;"><?= $tvalue[0]['fee']; ?></td>
							<td style="width:80px;"><?= $tvalue[0]['total_paid']; ?></td>
							<td style="width:80px;"><?= $tvalue[0]['fee']-$tvalue[0]['total_paid']; ?></td>
						</tr> 
					<?php }else { ?>
						<?php $total_fee=0; ?>
						<?php foreach ($tvalue as $nindex => $nvalue) { ?>
							<?php $total_fee+=$nvalue['fee']; ?>
						<?php } ?>
						<?php foreach ($tvalue as $nindex => $nvalue) { ?>
							<tr> 
								<?php if($nindex == 0){ ?>
									<td style="width:80px;" rowspan="<?= sizeof($tvalue); ?>"><?= $t; ?></td>
								<?php } ?>
								<td style="width:80px;"><?= $nvalue['tooth']; ?></td>
								<td style="width:200px;"><?= $nvalue['render']; ?></td>
								<td><?= $tvalue[0]['doctor_name']; ?></td>
								<td style="width:80px;"><?= $nvalue['fee']; ?></td>
								
								<?php if($nindex == 0){ ?>
									<td style="width:80px;"  rowspan="<?= sizeof($tvalue); ?>" ><?= $nvalue['total_paid']; ?></td>
									<td style="width:80px;"  rowspan="<?= sizeof($tvalue); ?>" ><?= $total_fee-$nvalue['total_paid']; ?></td>
								<?php } ?>
							
							</tr> 

						<?php } ?>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>

<?php } ?>
<?php if($xray){ ?>
	<style>
		.xray-container
		{
			
			width: 100%;
			height: 600px;
			position:relative;
			top:130px;

		}
		.tbl-xray-4
		{
			width: 100%;
			height: 30%;
		}
		.tbl-xray-4 td
		{
			width: 25%;
		}
		.tbl-xray-3
		{
			width: 100%;
			height: 35%;
		}
		.tbl-xray-3 td
		{
			width: 33.33333333%;
		}
		.bg-image {
		  background-position: center center;
		  background-repeat: no-repeat;
		  background-size: cover;
		  height: 25%;
		  width: 100%;
		}
		.bg-image-big {
		  background-position: center center;
		  background-repeat: no-repeat;
		  background-size: cover;
		  height: 35%;
		  width: 100%;
		}
	</style>	

	<div class="container patient-info" style="position:relative;">
		<div class="row name" style="margin-bottom:100px;text-align:center;">
			<div class="col-md-4" style="position:absolute;left:50px;">
				<p>Name:<input type="" name="" style="width:200px;text-align:center;" value="<?php echo $patient->lastname; ?>"></p>
				<p>Last</p>
			</div>
			<div class="col-md-4" style="position:absolute;left:350px;">
				<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->firstname; ?>"></p>
				<p>First</p>
			</div>
			<div class="col-md-4" style="position:absolute;left:610px;">
				<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->middlename; ?>"></p>
				<p>Middle</p>
			</div>
		</div>
	</div>

	<div class="title" style="position:relative;top:120px;margin-right:10px;">
		<p><strong>BEFORE</strong></p>
	</div>

	<div class="xray-container">
		<table border="1" class="tbl-xray-4">
			<tr>
				<?php if($patient_xray_before){ ?>
					<?php for($i=1;$i < 5;$i++) { ?>
						<td>
							<?php $img=explode('/', $patient_xray_before[$i]['filename']) ?>
							<?php 
								$str_img="";
								foreach ($img as $key => $val) {
									if($key > 1)
									{
										$str_img.='/'.$val;
									}
									
								}
							?>
							<?php if($str_img !='' ){ ?>
								<img class="bg-image" src='<?= ROOT.$str_img; ?>' >
							<?php } ?>
						</td>
					<?php } ?>		

				<?php }else{ ?>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<?php } ?>
				
			</tr>
		</table>
		<?php if($patient_xray_before){ ?>
			<?php for($i=5;$i < 11;$i++) { ?>
				<?php if($i == 5 || $i == 8){ ?>
					<table border="1" class="tbl-xray-3"><tr>
				<?php } ?>
				<?php if($i != 6){ ?>
					<?php $img=explode('/', $patient_xray_before[$i]['filename']) ?>
					<?php 
						$str_img="";
						foreach ($img as $key => $val) {
							if($key > 1)
							{
								$str_img.='/'.$val;
							}
							
						}
					?>
					<td>
						<?php if($str_img !='' ){ ?>
							<img class="bg-image-big" src='<?= ROOT.$str_img; ?>' >
						<?php } ?>
					</td>
				<?php }else { ?>	
					<td style="text-align:center;"><?= $hdr_user_data['company']; ?></td>
				<?php } ?>
				<?php if($i == 7 || $i == 10){ ?>
					</tr></table>
				<?php } ?>
			<?php } ?>
		<?php }else{ ?>
			<table border="1" class="tbl-xray-3">
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			<table border="1" class="tbl-xray-3">
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php } ?>
	</div>

	<br/><br/><br/><br/><br/><br/><br/><br/>
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<br/><br/><br/><br/><br/><br/><br/><br/>

	<div class="container patient-info" style="position:relative;">
		<div class="row name" style="margin-bottom:100px;text-align:center;">
			<div class="col-md-4" style="position:absolute;left:50px;">
				<p>Name:<input type="" name="" style="width:200px;text-align:center;" value="<?php echo $patient->lastname; ?>"></p>
				<p>Last</p>
			</div>
			<div class="col-md-4" style="position:absolute;left:350px;">
				<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->firstname; ?>"></p>
				<p>First</p>
			</div>
			<div class="col-md-4" style="position:absolute;left:610px;">
				<p><input type="" name="" style="width:200px;text-align:center;"  value="<?php echo $patient->middlename; ?>"></p>
				<p>Middle</p>
			</div>
		</div>
	</div>

	<div class="title" style="position:relative;top:120px;margin-right:10px;">
		<p><strong>AFTER</strong></p>
	</div>

	<div class="xray-container">
		<table border="1" class="tbl-xray-4">
			<tr>
				<?php if($patient_xray_after){ ?>
					<?php for($i=1;$i < 5;$i++) { ?>
						<td>
							<?php $img=explode('/', $patient_xray_after[$i]['filename']) ?>
							<?php 
								$str_img="";
								foreach ($img as $key => $val) {
									if($key > 1)
									{
										$str_img.='/'.$val;
									}
									
								}
							?>
							<?php if($str_img !='' ){ ?>
								<img class="bg-image" src='<?= ROOT.$str_img; ?>' >
							<?php } ?>
						</td>
					<?php } ?>		

				<?php }else{ ?>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				<?php } ?>
				
			</tr>
		</table>
		<?php if($patient_xray_after){ ?>
			<?php for($i=5;$i < 11;$i++) { ?>
				<?php if($i == 5 || $i == 8){ ?>
					<table border="1" class="tbl-xray-3"><tr>
				<?php } ?>
				<?php if($i != 6){ ?>
					<?php $img=explode('/', $patient_xray_after[$i]['filename']) ?>
					<?php 
						$str_img="";
						foreach ($img as $key => $val) {
							if($key > 1)
							{
								$str_img.='/'.$val;
							}
							
						}
					?>
					<td>
						<?php if($str_img !='' ){ ?>
							<img class="bg-image-big" src='<?= ROOT.$str_img; ?>' >
						<?php } ?>
					</td>
				<?php }else { ?>	
					<td style="text-align:center;"><?= $hdr_user_data['company']; ?></td>
				<?php } ?>
				<?php if($i == 7 || $i == 10){ ?>
					</tr></table>
				<?php } ?>
			<?php } ?>
		<?php }else{ ?>
			<table border="1" class="tbl-xray-3">
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			<table border="1" class="tbl-xray-3">
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
		<?php } ?>
	</div>

<?php } ?>
<?php if($presc){ ?>
	<style>
		.header-title {
		  color: #2196f3;
		  font-size: 38px;
		  text-align: center;
		  margin-bottom: 33px;
		}
		.patient-info-2 {
		  font-size: 26px;
		  text-align: center;
		  width: 100%;
		}
		.patient-info-2 p {
		  margin-bottom: 20px;
		}
		.patient-info-2 input {
		  border: 0px;
		  border-bottom: 2px solid;
		  width: 80%;
		}
		.parent-div{
			
			border: 0px solid;
		}
		.footer-left{
			width: 50%;
			font-size: 20px;
			color: #2196f3;
		}
		.footer-left p{
			margin-top: 15px;
		}
		.footer-right {
		  text-align: center;
		}
		.footer-table{
			width: 100%;
		}
		.footer-right > input {
		  font-size: 25px;
		  text-align: center;
		  border: 0px;
		  border-bottom: 1px solid;
		  width: auto;
		}
		.presc-footer{
			border: 0px solid;
			position: relative;
		}
		.tbl-logo{
			width: 100%;
		}
		.logo-right input {
		  border:0px;
		  border-bottom:2px solid;
		  width: 43%;
		}
		.logo-right {
		  font-size: 28px;
		  text-align: center;
		}
		.presc-data {
		  padding: 35px 0px;
		}
		.presc-data > table {
		  font-size: 20px;
		  text-align: center;
		  width: 1000px;
		}
		.presc-data th {
		  padding-bottom: 20px;
		}
		.presc-data td {
		  padding-bottom: 5px;
		}
	</style>
	
	<div class="parent-div">
		<div class="header-title">
			<p><?= $hdr_user_data['company']; ?></p>
			<p><?= $hdr_user_data['address'].",".$hdr_user_data['city']." ".$hdr_user_data['province']; ?></p>
			<p><?= $hdr_user_data['contact_number']; ?></p>
		</div>
		<div class="patient-info-2" >
			<p>Patient: <span><input type="text" id="sample-id" value="<?= $patient->firstname.'	'.$patient->middlename.'.	'.$patient->lastname; ?>" ></span></p>
			<p>Address: <span><input type="text" id="sample-id-2" value="<?= $patient->address; ?>" ></span></p>
		</div>
		<table class="tbl-logo">
			<tr>
				<td style="width:50%;">
					<div class="logo-left">
						<img src="<?= ROOT.'/assets/images/rxlogo.png'; ?>" />
					</div>
				</td>
			
				<td>
					<div class="logo-right">
						<p>Date: <span><input type="text" value="<?= date("M d, Y", strtotime($prescription_date)); ?>" ></span></p>
					</div>
				</td>
			</tr>
		</table>
		<div class="presc-data" >
			<table>
				<tr>
					<th>Generic</th>
					<th>Brand</th>
					<th>Quantity</th>
					<th>Dosage</th>
					<th>Signature</th>
				</tr>
				<?php foreach($patient_prescription as $key => $values) { ?>
	            	<?php foreach($values as $k => $value) { ?>
						<tr>
							 <td>
		                        <span class="label-<?= $value['id']; ?> lbl"><?= $value['generic']; ?></span>
		                        <input type="text" id="inp-generic-<?= $value['id']; ?>" class="inp-<?= $value['id']; ?> inp" value="<?= $value['generic']; ?>" style="display: none;" />
		                    </td>
		                    <td>
		                        <span class="label-<?= $value['id']; ?> lbl"><?= $value['brand']; ?></span>
		                        <input type="text" id="inp-brand-<?= $value['id']; ?>" class="inp-<?= $value['id']; ?> inp" value="<?= $value['brand']; ?>" style="display: none;" />
		                    </td>
		                    <td>
		                        <span class="label-<?= $value['id']; ?> lbl"><?= $value['quantity']; ?></span>
		                        <input type="text" id="inp-quantity-<?= $value['id']; ?>" class="inp-<?= $value['id']; ?> inp" value="<?= $value['quantity']; ?>" style="display: none; width: 90%;" />
		                    </td>
		                    <td>
		                        <span class="label-<?= $value['id']; ?> lbl"><?= $value['dosage']; ?></span>
		                        <input type="text" id="inp-dosage-<?= $value['id']; ?>" class="inp-<?= $value['id']; ?> inp" value="<?= $value['dosage']; ?>" style="display: none; width: 90%;" />
		                    </td>
		                    <td>
		                        <span class="label-<?= $value['id']; ?> lbl"><?= $value['signature']; ?></span>
		                        <input type="text" id="inp-signature-<?= $value['id']; ?>" class="inp-<?= $value['id']; ?> inp" value="<?= $value['signature']; ?>" style="display: none;" />
		                    </td>
						</tr>
					<?php } ?>
				<?php } ?>
			</table>
		</div>
	</div>

	
	
	<div class="presc-footer">
		<table class="footer-table">
			<tr>
				<td style="width:50%;">
					<div class="footer-left">
						<p>PTR :</p>
						<p>S2 License No. :</p>
						<p>License No. :</p>
					</div>
				</td>
			
				<td>
					<div class="footer-right">
						<input tpye="text" value="Dr. <?= strtoupper($hdr_user_data['firstname'] . " " . $hdr_user_data['lastname']); ?>" />
						<p>Signature over printed name</p>
					</div>
				</td>
			</tr>
		</table>
	</div>

	

<?php } ?>
<script type="text/javascript" src="<?php echo ROOT.DS.'assets'.DS.'js'.DS.'jquery.js'; ?>" ></script>		
<script type="text/javascript" src="<?php echo ROOT.DS.'assets'.DS.'js'.DS.'bootstrap.js'; ?>" ></script>
<?php if($presc){ ?>
	<script>
		$(document).ready(function(){

			

			var parent = parseInt($(".parent-div").height());
			var footer = parseInt($(".presc-footer").height());
			var margin = 0;
			var modu = Math.floor(parent/900);
			
			if(parent > 780)
				min=parent - 780;
			else
				min = 0;

			margin = 800 - min;

			$("#sample-id-2").val(parent);
			$(".presc-footer").css('top',margin+"px");
			
		});
		
	</script>
<?php } ?>
<?php if($drc){ ?>

<script type="text/javascript" src="<?php echo ROOT.DS.'assets'.DS.'js'.DS.'dental-chart.js'; ?>" ></script>
<?php } ?>
