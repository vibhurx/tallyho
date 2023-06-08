

<h1>Tallyho&trade; - Privacy Policy</h1>

<table class="action">
	<tr><td>Credit
			This document was created using a Contractology template available at http://www.freenetlaw.com.
		</td></tr>
	<tr><td>
		Your privacy is important to Brevity Labs.  This privacy statement provides information about the personal information that Brevity Labs  collects, and the ways in 
		which Brevity Labs  uses that personal information.
		<br><br>
		
		
		<h2>Personal information collection</h2>
		
		Brevity Labs  may collect and use the following kinds of personal information: 
		<br><br>
		<ol>
			<li>information about your use of this website (including name, date-of-birth, place of residence, gender); </li>
			<li>information that you provide using for the purpose of registering with the website (including name, contact information like email address and phone number);</li>
			<li>information about transactions carried out over this website (including enrollment or participant in a tournament, scores attained in the matches); </li>
			<li>information that you provide for the purpose of subscribing to the website services (including email address); and</li>
			<li>any other information that you send to Brevity Labs.</li>
		</ol>
		
		<br>
		<h2>Using personal information</h2>
		
		Brevity Labs  may use your personal information to: 
		<br><br>
		<ol>
			<li>administer this website;</li>
			<li>personalize the website for you;</li>
			<li>enable your access to and use of the website services;</li>
			<li>publish information about you on the website;</li>
			<li>send to you products that you purchase;</li>
			<li>supply to you services that you purchase;</li>
			<li>send to you statements and invoices;</li>
			<li>collect payments from you; and</li>
			<li>send you marketing communications.</li>
		</ol>
		<br>
		Where Brevity Labs  discloses your personal information to its agents or sub-contractors for these purposes, the agent or sub-contractor in question will be 
		obligated to use that personal information in accordance with the terms of this privacy statement. <br>
		<br>
		In addition to the disclosures reasonably necessary for the purposes identified elsewhere above, Brevity Labs  may disclose your personal information to the
		extent that it is required to do so by law, in connection with any legal proceedings or prospective legal proceedings, and in order to establish,
		exercise or defend its legal rights.<br>
		<br>
		
		<h2>Securing your data</h2>
		
		Brevity Labs  will take reasonable technical and organisational precautions to prevent the loss, misuse or alteration of your personal information. <br>
		<br>
		Brevity Labs  will store all the personal information you provide on the servers provided by a reputed hosting company. <br>
		<br>
		Information relating to electronic transactions entered into via this website will be  protected by encryption technology.<br>
		<br><br>
		
		<h2>Cross-border data transfers</h2>
		<br>
		Information that Brevity Labs  collects may be stored and processed in and transferred between any of the countries in which Brevity Labs operates to enable the 
		use of the information in accordance with this privacy policy.<br>
		<br>
		In addition, personal information that you submit for publication on the website will be published on the internet and may be available around the world.<br>
		<br>
		You agree to such cross-border transfers of personal information.<br>
		<br><br>
		
		<h2>Updating this statement</h2>
		
		Brevity Labs  may update this privacy policy by posting a new version on this website.  <br>
		<br>
		You should check this page occasionally to ensure you are familiar with any changes.  <br>
		<br><br>
		
		<h2>Other websites</h2>
		
		This website contains links to other websites.  <br>
		<br>
		Brevity Labs  is not responsible for the privacy policies or practices of any third party.<br>
		
		<br><br>
		<h2>Contact Brevity Labs</h2> 
		
		If you have any questions about this privacy policy or Brevity Lab's treatment of your personal information, please write:
		
		by email to admin@tallyho.in; or 
		by post to 101 St.Raphaela's Apartment, St. Raphaela's Road, Stillorgan Heath, Stillorgan, Co. Dublin, Ireland.
			
	</td></tr>	
</table>

<?php 
if(isset($_GET['src'])){
	$src = $_GET['src'];
	echo CHtml::link("Back to " . $src, array('/site/page/view/'.$src));
} else {
	echo CHtml::link("Back to home", array('/'));
}
?>