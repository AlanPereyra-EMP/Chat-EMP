<?php
// "[chat-emp]" shortcode
if(!shortcode_exists('chat-emp')) {

  function cemp_shortcode($atts) {
    //TODO: add more admins support via shortcode atrubutes
    $atributes = shortcode_atts( array(
      'pass' => 'false',
      'terms'=> 'false',
      'poli'=> 'false',
      'admins' => '1'
    ), $atts );

    // Save necessary data on JS global variables
    $cemp_pass = $atributes['pass'];
    $terms = $atributes['terms'];
    $poli = $atributes['poli'];
    $admins = $atributes['admins'];
    $cemp_url = plugins_url('', __DIR__ );
    $js_variables = '<script>
                      var cempUrl = "'.$cemp_url.'";
                      var cempPass = "'. $cemp_pass .'"; '.
                      'var cempTerms = "'. $terms .'"; '.
                      'var cempPoli = "'. $poli .'"; '.
                      'var cempAdmins = "'. $admins .'";'.
                    '</script>';

    // Enqueue all Js and Css
    add_action('wp_enqueue_scripts','add_cemp_styles', 9, 1);
    if(!is_user_logged_in()){
      add_action('wp_enqueue_scripts','add_cemp_login_script');
      add_action('wp_enqueue_scripts','add_cemp_logup_script');
    }else{
      add_action('wp_enqueue_scripts','add_cemp_script', 9, 1);
      add_action('wp_enqueue_scripts','add_cemp_get_messages_script', 8, 1);
      add_action('wp_enqueue_scripts','add_cemp_send_messages_script', 8, 1);
      add_action('wp_enqueue_scripts','add_cemp_notifications_script', 8, 1);
      add_action('wp_enqueue_scripts','add_cemp_messages_list_script', 10, 1);

      has_user_chat($admins);
      register_users();
    }

    // Components
    $remain_char = '<div id="remain-char"></div>';

    $form = '<form id="cemp-form">
              <input name="to" type="hidden"/>
              <textarea id="message-bar" class="form-height" name="msg" placeholder="Escribe un mensaje" maxlength="240" cols="40" rows="5"></textarea>
              <button id="message-button" class="form-height cemp-btn-success" type="submit">
                <i class="fas fa-paper-plane"></i>
              </button>
            </form>';

    $list_display = '<div id="cemp-list-display" class="cemp-hide-list">
                      <i id="cemp-list-display-button" class="fas fa-comment-dots"></i>
                    </div>';
    $user_list = '<div id="cemp-list"></div>';

    $login = '<div id="cemp-config-page" class="cemp-d-none"></div>';

    return '<div style="height:100vh;"></div>
            <div id="cemp-page">'.
              $login.
              $list_display.
              '<div id="cemp-div" class="cemp-fade-in" style="opacity:0;">'.
                $user_list.
                '<div id="cemp-chat-div">
                  <div id="new-messages-count" class="cemp-d-none"></div>
                  <div id="cemp-messages"></div>
                  <div id="cemp-textarea-div">'.
                  $remain_char.
                  $form.
                  '</div>
                </div>
              </div>
            </div>'.
            $js_variables;
  }
  add_shortcode('chat-emp', 'cemp_shortcode');
}
?>
