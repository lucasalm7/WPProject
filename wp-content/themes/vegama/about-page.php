<?php
get_header();
?>

<main class="page-shell about-page">
    <section class="about-hero">
        <div class="about-hero__inner">
            <p class="sec-eye">About Vegama</p>
            <h1>Plant-based living, shaped by culture and craft.</h1>
            <p>
                Vegama brings together thoughtful recipes, immersive events, and a slower way of eating through food.
                We believe plant-based living can be beautifully practical and deeply nourishing.
            </p>
        </div>
    </section>

    <section class="about-layout">
        <div class="about-copy">
            <div class="about-card">
                <h2>Our story</h2>
                <p>
                    Founded in Denmark, Vegama started with a simple idea: good food should be kind, beautiful, and memorable.
                    We create recipe content, cookbooks, and workshops that help people cook with confidence while staying close to the planet.
                </p>
            </div>

            <div class="about-card">
                <h2>What we do</h2>
                <ul>
                    <li>Plant-based recipes and seasonal inspiration</li>
                    <li>Cooking classes and community events</li>
                    <li>Cookbooks, workshops, and food storytelling</li>
                    <li>Partnerships with brands and creative founders</li>
                </ul>
            </div>
        </div>

        <div class="about-form-wrap">
            <div class="about-form-card">
                <p class="sec-eye sec-eye--dark">Get in touch</p>
                <h2>Work with us</h2>

                <?php if ( isset($_GET['status']) && $_GET['status'] === 'success' ) : ?>
                    <div class="vegama-success-box" style="background:#eef4f1; color:#2e5a44; padding:20px; border-radius:8px; margin-top:20px; font-weight:bold; text-align:center;">
                        Thanks! We’ve received your message and will get back to you within 24–48 hours.
                    </div>
                <?php else : ?>

                    <form id="vegama-conversational-form" class="vegama-contact-form" method="post" action="<?php echo esc_url( get_permalink() ); ?>">
                        <?php wp_nonce_field( 'vegama_about_form', 'vegama_about_nonce' ); ?>
                        
                        <input type="hidden" name="vegama_main_intent" id="vegama_main_intent" value="">
                        <input type="hidden" name="vegama_sub_category" id="vegama_sub_category" value="">

                        <div class="form-step active" data-step="1">
                            <h3>Hi there! Welcome to The Plant Kitchen. How can we help you today?</h3>
                            <div class="conv-options">
                                <button type="button" class="conv-btn" data-next="support-step2" data-intent="General Question">I have a general question about an existing Masterclass or e-book.</button>
                                <button type="button" class="conv-btn" data-next="b2b-step2" data-intent="B2B Inquiry">I'm interested in corporate partnerships or B2B inquiries.</button>
                                <button type="button" class="conv-btn" data-next="press-step2" data-intent="Press Request">I have a press, media, or collaboration request.</button>
                                <button type="button" class="conv-btn" data-next="feedback-step2" data-intent="Community Feedback">I want to share feedback or ask a general cooking question.</button>
                            </div>
                        </div>

                        <div class="form-step" data-step="support-step2" data-branch="support">
                            <h3>Happy to help! What is your question related to?</h3>
                            <div class="conv-options">
                                <button type="button" class="conv-sub-btn" data-next="support-step3" data-sub="Physical Masterclasses">Physical Masterclasses (venues, dietary requirements, or tickets)</button>
                                <button type="button" class="conv-sub-btn" data-next="support-step3" data-sub="E-books / Digital Downloads">E-books / Digital Downloads (download links or technical issues)</button>
                                <button type="button" class="conv-sub-btn" data-next="support-step3" data-sub="General Blog Recipes">General blog recipes or ingredients</button>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="1">← Back</button>
                        </div>

                        <div class="form-step" data-step="support-step3" data-branch="support">
                            <h3>Tell us a bit more so we can assist you better.</h3>
                            <div class="form-grid">
                                <label class="full-width">
                                    <span>Your Question</span>
                                    <textarea name="vegama_message" rows="4" minlength="10" maxlength="1000" required placeholder="How can we help? (Min 10 chars)"></textarea>
                                </label>
                                <label>
                                    <span>Full Name</span>
                                    <input type="text" name="vegama_name" pattern="^[a-zA-ZÀ-ÿ\s'-]{2,}$" required placeholder="Your Name">
                                </label>
                                <label>
                                    <span>Email Address</span>
                                    <input type="email" name="vegama_email" required placeholder="name@domain.com">
                                </label>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="support-step2">← Back</button>
                            <button type="submit" name="vegama_about_submit" value="1" class="btn-primary btn-primary--dark">Send message</button>
                        </div>

                        <div class="form-step" data-step="b2b-step2" data-branch="b2b">
                            <h3>We love collaborating! What type of inquiry is this?</h3>
                            <div class="conv-options">
                                <button type="button" class="conv-sub-btn" data-next="b2b-step3" data-sub="Corporate Wellness">Corporate wellness event or private workshop inquiry</button>
                                <button type="button" class="conv-sub-btn" data-next="b2b-step3" data-sub="Brand Sponsorship">Brand sponsorship / Scandinavian micro-influencer collaboration</button>
                                <button type="button" class="conv-sub-btn" data-next="b2b-step3" data-sub="Other Corporate Partnership">Other corporate partnership</button>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="1">← Back</button>
                        </div>

                        <div class="form-step" data-step="b2b-step3" data-branch="b2b">
                            <h3>Who should we reach out to regarding this opportunity?</h3>
                            <div class="form-grid">
                                <label>
                                    <span>Company / Brand Name</span>
                                    <input type="text" name="vegama_company" pattern="^[a-zA-Z0-9À-ÿ\s&.,'-]+$" required placeholder="Company Name, ApS">
                                </label>
                                <label>
                                    <span>Contact Person</span>
                                    <input type="text" name="vegama_name" pattern="^[a-zA-ZÀ-ÿ\s'-]{2,}$" required placeholder="Full Name">
                                </label>
                                <label class="full-width">
                                    <span>Work Email</span>
                                    <input type="email" name="vegama_email" required placeholder="name@company.com">
                                </label>
                                <label class="full-width">
                                    <span>Short Description</span>
                                    <textarea name="vegama_message" rows="4" minlength="10" maxlength="1000" required placeholder="Tell us a bit about your idea or event..."></textarea>
                                </label>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="b2b-step2">← Back</button>
                            <button type="submit" name="vegama_about_submit" value="1" class="btn-primary btn-primary--dark">Send message</button>
                        </div>

                        <div class="form-step" data-step="press-step2" data-branch="press">
                            <h3>Thanks for reaching out! What publication or channel are you representing?</h3>
                            <div class="conv-options">
                                <button type="button" class="conv-sub-btn" data-next="press-step3" data-sub="Food/Lifestyle Magazine">Food / Lifestyle Magazine or Blog</button>
                                <button type="button" class="conv-sub-btn" data-next="press-step3" data-sub="Podcast/Social Channel">Podcast or Social Media Channel</button>
                                <button type="button" class="conv-sub-btn" data-next="press-step3" data-sub="Local News">Local News / Event Feature</button>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="1">← Back</button>
                        </div>

                        <div class="form-step" data-step="press-step3" data-branch="press">
                            <h3>Where should our PR team send press assets and responses?</h3>
                            <div class="form-grid">
                                <label>
                                    <span>Name</span>
                                    <input type="text" name="vegama_name" pattern="^[a-zA-ZÀ-ÿ\s'-]{2,}$" required placeholder="Your Name">
                                </label>
                                <label>
                                    <span>Email Address</span>
                                    <input type="email" name="vegama_email" required placeholder="name@media.com">
                                </label>
                                <label class="full-width">
                                    <span>Inquiry Details</span>
                                    <textarea name="vegama_message" rows="4" minlength="10" maxlength="1000" required placeholder="Deadlines, interview requests, or asset needs..."></textarea>
                                </label>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="press-step2">← Back</button>
                            <button type="submit" name="vegama_about_submit" value="1" class="btn-primary btn-primary--dark">Send message</button>
                        </div>

                        <div class="form-step" data-step="feedback-step2" data-branch="feedback">
                            <h3>We always love hearing from our community! What's on your mind?</h3>
                            <div class="form-grid">
                                <label class="full-width">
                                    <span>Message</span>
                                    <textarea name="vegama_message" rows="4" minlength="10" maxlength="1000" required placeholder="Type your message here..."></textarea>
                                </label>
                                <label>
                                    <span>Your Name</span>
                                    <input type="text" name="vegama_name" pattern="^[a-zA-ZÀ-ÿ\s'-]{2,}$" required placeholder="Your Name">
                                </label>
                                <label>
                                    <span>Email Address</span>
                                    <input type="email" name="vegama_email" required placeholder="name@domain.com">
                                </label>
                            </div>
                            <button type="button" class="conv-back-btn" data-prev="1">← Back</button>
                            <button type="submit" name="vegama_about_submit" value="1" class="btn-primary btn-primary--dark">Send message</button>
                        </div>

                        <div class="conv-gdpr" style="margin-top: 15px; font-size: 12px; color: #666;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="checkbox" name="vegama_gdpr" required style="width: auto;">
                                I consent to having Vegama store my submitted information to respond to this inquiry.
                            </label>
                        </div>
                    </form>

                    <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const steps = document.querySelectorAll(".form-step");
                        
                        document.querySelectorAll(".conv-btn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                document.getElementById("vegama_main_intent").value = this.getAttribute("data-intent");
                                switchStep(this.getAttribute("data-next"));
                            });
                        });

                        document.querySelectorAll(".conv-sub-btn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                document.getElementById("vegama_sub_category").value = this.getAttribute("data-sub");
                                switchStep(this.getAttribute("data-next"));
                            });
                        });

                        document.querySelectorAll(".conv-back-btn").forEach(btn => {
                            btn.addEventListener("click", function() {
                                switchStep(this.getAttribute("data-prev"));
                            });
                        });

                        function switchStep(targetStep) {
                            steps.forEach(step => {
                                step.classList.remove("active");
                                if(step.getAttribute("data-step") === targetStep) {
                                    step.classList.add("active");
                                }
                            });
                        }
                    });
                    </script>

                    

                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<style>
    .form-step { 
        display: none; 
    }
    .form-step.active { 
        display: block; 
    }
    .conv-options { 
        display: flex; flex-direction: column; gap: 10px; margin: 20px 0; 
    }
    .conv-btn,

    .conv-sub-btn {
        padding: 16px 18px;
        text-align: left;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        line-height: 1.5;
        color: var(--txt);
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(24, 95, 48, 0.16);
        border-radius: 14px;
        transition: all 0.2s ease;
        box-shadow: 0 6px 16px rgba(24, 95, 48, 0.04);
    }

    .conv-btn:hover,
    .conv-sub-btn:hover {
        background: var(--sage);
        color: #fff;
        border-color: var(--sage);
        transform: translateY(-1px);
    }
    
    button.btn-primary,
    button.btn-primary--dark,
    .btn-primary,
    .btn-primary--dark {
    border: none;
    outline: none;
    -webkit-appearance: none;
    appearance: none;
    box-shadow: none;
    }

    .conv-back-btn { 
        background: none; 
        border: none; 
        color: #666; 
        cursor: pointer; 
        padding: 5px 0; 
        margin-top: 15px; 
        font-size: 13px;
        }
</style>
<?php
get_footer();
?>