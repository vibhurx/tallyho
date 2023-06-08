<h1>Tallyho&trade; - Disclaimer</h1>
<hr/>
<table class="action">
	<tr><td>Credit
			This document was created using a Contractology template available at http://www.freenetlaw.com.
		</td></tr>

	<tr><td>
	
	<h2>No warranties</h2>
		This website is provided "as is" without any representations or warranties, express or implied.  Brevity Labs makes no representations or 
		warranties in relation to this website or the information and materials provided on this website.  <br><br>
		Without prejudice to the generality of the foregoing paragraph, Brevity Labs does not warrant that: <br><br>
		
		<ol>
			<li>this website will be constantly available, or available at all; or</li>
			<li>the information on this website is complete, true, accurate or non-misleading.</li>
			<li>The effort has been to keep the application logic as close as to AITA's (All-India Tennis Association) latest policies. 
				New policies may take time to update in the app.</li>
		</ol>	

		Nothing on this website constitutes, or is meant to constitute, advice of any kind.
		<br><br>

	<h2>Limitations of liability</h2>

		Brevity Labs will not be liable to you (whether under the law of contract, the law of torts or otherwise) in relation to the contents 
		of, or use of, or otherwise in connection with, this website:<br><br>
		
		<ol>
			<li>[to the extent that the website is provided free-of-charge, for any direct loss;]</li>
			<li>for any indirect, special or consequential loss; or</li>
			<li>for any business losses, loss of revenue, income, profits or anticipated savings, loss of contracts or business relationships,
			loss of reputation or goodwill, or loss or corruption of information or data.</li>
		</ol>
		
		These limitations of liability apply even if Brevity Labs has been expressly advised of the potential loss.
		<br><br>
		
	<h2>Exceptions</h2>

		Nothing in this website disclaimer will exclude or limit any warranty implied by law that it would be unlawful to exclude or limit; 
		and nothing in this website disclaimer will exclude or limit Brevity Labs liability in respect of any:<br><br>
		<ol>
			<li>	death or personal injury caused by Brevity Labs negligence;</li>
			<li>	fraud or fraudulent misrepresentation on the part of Brevity Labs; or</li>
			<li>	matter which it would be illegal or unlawful for Brevity Labs to exclude or limit, or to attempt or purport to exclude or limit, its liability.</li>
		</ol> 
		
	<h2>Reasonableness</h2>

		By using this website, you agree that the exclusions and limitations of liability set out in this website disclaimer are reasonable.  <br><br>
		
		If you do not think they are reasonable, you must not use this website.
		<br><br>
		
	<h2>Other parties</h2>

		You accept that, Brevity Labs being a freelance organisation is represented by its proprietor and other freelancers working on behalf of it, has an interest 
		in limiting the personal liability of its proprietor and associates. 
		You agree that you will not bring any claim personally against Brevity Labs proprietor or associates in respect of any losses you suffer in 
		connection with the website.<br><br>
		
		You agree that the limitations of warranties and liability set out in this website 
		disclaimer will protect Brevity Labs officers, employees, agents, subsidiaries, successors, assigns and sub-contractors as well as Brevity Labs. 
		<br><br>
		
	<h2>Unenforceable provisions</h2>

		If any provision of this website disclaimer is, or is found to be, unenforceable under applicable law, that will not affect the 
		enforceability of the other provisions of this website disclaimer.

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