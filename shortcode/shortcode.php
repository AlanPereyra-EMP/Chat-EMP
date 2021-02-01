<?php
// "[chat-emp]" shortcode

if(!shortcode_exists('chat-emp')) {

  function cemp_shortcode($atts) {
    // Enqueue all Js and Css
    add_action('wp_enqueue_scripts','add_cemp_styles', 9, 1);
    if(!is_user_logged_in()){
      add_action('wp_enqueue_scripts','add_cemp_login_script');
      add_action('wp_enqueue_scripts','add_cemp_logup_script');
    }else{
      add_action('wp_enqueue_scripts','add_cemp_messages_script', 10, 1);
      add_action('wp_enqueue_scripts','add_cemp_get_messages_script');
      add_action('wp_enqueue_scripts','add_cemp_send_messages_script');
      if(current_user_can( 'manage_options' ) ){
        add_action('wp_enqueue_scripts','add_cemp_messages_list_script', 9, 1);
      }
    }

    $atributes = shortcode_atts( array(
      'pass' => 'false',
      'terms'=> 'false',
      'poli'=> 'false'
    ), $atts );

    // Save necessary data on JS global variables
    $user_id = get_current_user_id();
    $cemp_pass = $atributes['pass'];
    $terms = $atributes['terms'];
    $poli = $atributes['poli'];
    $cemp_url = plugins_url('', __DIR__ );
    $js_variables = '<script>
                      var cempUrl = "'.$cemp_url.'";
                      var cempPass = "'. $cemp_pass .'"; '.
                      'var cempUserId = "'. $user_id .'"; '.
                      'var cempTerms = "'. $terms .'"; '.
                      'var cempPoli = "'. $poli .'"; '.
                    '</script>';


    // Components
    $remain_char = '<div id="remain-char"></div>';

    $form = '<form id="cemp-form">
              <textarea id="message-bar" class="form-height" name="msg" placeholder="Escribe un mensaje" maxlength="240" cols="40" rows="5"></textarea>
              <button id="message-button" class="form-height cemp-btn-success" type="submit">Enviar</button>
            </form>';


    if(current_user_can( 'manage_options' ) ){
      $list_display = '<div id="cemp-list-display">Ocultar Chats</div>';
      $user_list = '<div id="cemp-list"></div>';
    }else {
      $user_list = '';
      $list_display = '';
    }

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
