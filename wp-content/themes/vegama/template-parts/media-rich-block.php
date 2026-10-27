<?php
/**
 * Reusable Media-Rich Section for Main Pages
 * Campaign: One dinner counts
 */
?>
<section class="media-rich-campaign-sec" style="background: var(--sage, #185f30); padding: 80px 20px; color: var(--parch, #f4eedc); margin-top: 60px;">
  <div style="max-width: 1240px; margin: 0 auto;">
    
    <div style="text-align: center; max-width: 700px; margin: 0 auto 48px auto;">
      <span style="font-family: var(--fb); font-size: 11px; font-weight: 700; letter-spacing: 6px; text-transform: uppercase; opacity: 0.8; display: block; margin-bottom: 12px;">One Dinner Counts</span>
      <h2 style="font-family: var(--fd); font-style: italic; font-weight: 900; font-size: clamp(2.2rem, 5vw, 3.8rem); line-height: 1.1; margin: 0 0 16px 0;">See the kitchen in action.</h2>
      <p style="font-family: var(--fb); font-size: 16px; opacity: 0.9; line-height: 1.6; margin: 0;">You don't have to go vegan. Cook one plant-based dinner this week with our community and see how easy it is.</p>
    </div>

    <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px; align-items: center;" class="media-rich-grid">
      
      <!-- Video Container -->
      <div style="border-radius: 20px; overflow: hidden; background: rgba(0,0,0,0.2); box-shadow: 0 20px 40px rgba(0,0,0,0.15); aspect-ratio: 16/9; position: relative;">
        <iframe width="100%" height="100%" src="../assets/videos/vegama-reel-720.mp4" title="One Dinner Counts Campaign Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width:100%; height:100%; border:0; display:block;"></iframe>
      </div>

      <!-- 3 Photos Grid Stack -->
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
        <div style="grid-column: span 2; border-radius: 16px; overflow: hidden; aspect-ratio: 16/9; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
          <img src="<?php echo esc_url( get_template_directory_uri() . '../assets/images/vegan-spanish-tortilla-serve.webp' ); ?>" alt="Plant-based cooking preparation" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
        <div style="border-radius: 16px; overflow: hidden; aspect-ratio: 4/3; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
          <img src="<?php echo esc_url( get_template_directory_uri() . '../assets/images/tofu-scramble-avocado.webp' ); ?>" alt="Fresh organic ingredients" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
        <div style="border-radius: 16px; overflow: hidden; aspect-ratio: 4/3; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
          <img src="<?php echo esc_url( get_template_directory_uri() . '../assets/images/avocado-toast-step-3-serve.webp' ); ?>" alt="Community cooking together" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>
      </div>

    </div>
  </div>
</section>

<style>
@media (max-width: 900px) {
  .media-rich-grid {
    grid-template-columns: 1fr !important;
  }
}
</style>