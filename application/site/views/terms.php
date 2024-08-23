<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php

$this->load->view('head');

?>

<body ng-cloak>
	<!-- Horizontal Line -->
	<div class="hr-line red"></div>
	
	<div>
		
		<?php $this->load->view('header'); ?>
		
		<div class="container">
		
			<div class="row">
				<!-- Content -->
				<div class="col-lg-12">
					<h1><?php echo ucfirst(SITE_NAME); ?> Content Policy</h1>
					<p><?php echo ucfirst(SITE_NAME); ?> is a free service for communication, self-expression and freedom of speech. We believe <?php echo ucfirst(SITE_NAME); ?> increases the availability of information, encourages healthy debate, and makes possible new connections between people. It is our belief that censoring this content is contrary to a service that bases itself on freedom of expression.</p>
					<p>However, in order to uphold these values, we need to curb abuses that threaten our ability to provide this service and the freedom of expression it encourages. As a result, there are some boundaries on the type of content that can be hosted with <?php echo ucfirst(SITE_NAME); ?>. The boundaries we&#39;ve defined are those that both comply with legal requirements and that serve to enhance the service as a whole.</p>
					<p>If you encounter an article that you believe violates our policies, please report it to us (mohamedasif18@gmail.com).</p>
					<h2>Content Boundaries</h2>
					<p>Our content policies play an important role in maintaining a positive experience for you, the users. Please respect these guidelines. From time to time, we may change our content policies so please check back here. Also, please note that when applying the policies below, we may make exceptions based on artistic, educational, documentary, or scientific considerations or where there are other substantial benefits to the public from not taking action on the content.</p>
					<p><strong>Hate Speech:</strong> <?php echo ucfirst(SITE_NAME); ?> is a platform for free expression. But we don&#39;t support content that promotes or condones violence against individuals or groups based on race or ethnic origin, religion, disability, gender, age, nationality, veteran status, or sexual orientation/gender identity, or whose primary purpose is inciting hatred on the basis of these core characteristics. This can be a delicate balancing act, but if the primary purpose is to attack a protected group, the content crosses the line.</p>
					<p><strong>Crude Content:</strong> Don&#39;t post/comment content just to be shocking or graphic. For example, collections of close-up images of gunshot wounds or accident scenes without additional context or commentary would violate this policy.</p>
					<p><strong>Violence:</strong> Don&#39;t threaten other people by your comments. For example, don&#39;t post death threats against another person or group of people and don&#39;t post comments encouraging your readers to take violent action against another person or group of people.</p>
					<p><strong>Harassment:</strong> Do not harass or bully others. Anyone using <?php echo ucfirst(SITE_NAME); ?> to harass or bully may have the offending content removed or be permanently banned from the site. Online harassment is also illegal in many places and can have serious offline consequences.</p>
					<p><strong>Copyright:</strong> It is our policy to respond to clear notices of alleged copyright infringement. Also, please don&#39;t provide links where your readers can obtain unauthorized downloads of other people&#39;s content.</p>
					<p><strong>Personal and confidential information:</strong> It&#39;s not ok to publish another person&#39;s personal and confidential information. For example, don&#39;t post someone else&#39;s credit card numbers, Social Security numbers, unlisted phone numbers, and driver&#39;s license numbers. In addition, do not post or distribute images or videos of minors without the necessary consent from their legal representatives. If someone has posted an image or video of a minor without necessary consent. Also, please keep in mind that in most cases, information that is already available elsewhere on the Internet or in public records is not considered to be private or confidential under our policies.</p>
					<p><strong>Impersonating others:</strong> Please don&#39;t mislead or confuse readers by pretending to be someone else or pretending to represent an organization when you don&#39;t. We&#39;re not saying you can&#39;t publish parody or satire - just avoid content that is likely to mislead readers about your true identity.</p>
					<p><strong>Illegal activities:</strong> Do not use <?php echo ucfirst(SITE_NAME); ?> to engage in illegal activities or to promote dangerous and illegal activities. For example, don&#39;t author a blog encouraging people to drink and drive. Please also do not use <?php echo ucfirst(SITE_NAME); ?> to sell or promote illegal drugs. Otherwise, we may delete your content. Also, in serious cases such as those involving the abuse of children, we may report you to the appropriate authorities.</p>
					<p><strong>Regulated Goods and Services:</strong> Do not use <?php echo ucfirst(SITE_NAME); ?> to sell or facilitate the sale of regulated goods and services, such as alcohol, gambling, pharmaceuticals and unapproved supplements, tobacco, fireworks, weapons, or health/medical devices.</p>
					<p><strong>Spam:</strong> Spam takes several forms in <?php echo ucfirst(SITE_NAME); ?>, all of which can result in deletion of your account or blog. Some examples include creating blogs designed to drive traffic to your site or to move it up in search listings, posting comments on other people&#39;s blogs just to promote your site or product, and scraping existing content from other sources for the primary purpose of generating revenue or other personal gains.</p>
					<p><strong>Malware and viruses:</strong> Do not create blogs that transmit viruses, cause pop-ups, attempt to install software without the reader&#39;s consent, or otherwise impact readers with malicious code. This is strictly forbidden on <?php echo ucfirst(SITE_NAME); ?>.</p>
					<h2>Enforcement of <?php echo ucfirst(SITE_NAME); ?>&#39;s Content Policy</h2>
					<p>Please report suspected policy violations to us using the &#39;Report Abuse&#39; link located at the top of each blog under the &#39;More&#39; dropdown or by clicking <a target="_blank" href="/go/report-abuse" rel="noopener">here</a>.</p>
					<p>Our team reviews user flags for policy violations. If the comment does not violate our policies, we will not take any action against the commenter. If we find that a comment does violate our content policies, we take one or more of the following actions based on the severity of the violation:</p>
					<ul>
						<li>Delete the offending content, comment</li>
						<li>Disable the user access</li>
						<li>Report the user to law enforcement</li>
					</ul>
					<p>We may also take any of the above actions if we find that a user has commented engaging in repeated abusive behavior.</p>
					
					<h2>Copyright Information</h2>
					<p>All pages and graphics on this web site are the property of <?php echo ucfirst(SITE_NAME); ?>.</p>
					<p>Pages, code or other content from <?php echo ucfirst(SITE_NAME); ?> may not be redistributed or reproduced in any way, shape, or form without the written permission of <?php echo ucfirst(SITE_NAME); ?>.
					<p>Failure to do so is a violation of copyright laws.</p>
					
				</div>
				<!-- /Content -->
				
			</div>
		</div>
	</div>
	<?php $this->load->view('footer'); ?>