<?php
// "[chat-emp]" shortcode
if(!shortcode_exists('chat-emp')) {

  function cemp_shortcode($atts) {
    $atributes = shortcode_atts( array(
      'access' => 'false',
      'mode' => 'default',
      'terms'=> 'false',
      'poli'=> 'false',
      'admins' => '1',
      'changes' => 'false'
    ), $atts );

    // Save necessary data on JS global variables
    $access = $atributes['access'];
    if($access != 'false'){
      $cemp_pass = 'true';
    }
    $terms = $atributes['terms'];
    $poli = $atributes['poli'];
    $admins = $atributes['admins'];
    $changes = $atributes['changes'];
    $mode = $atributes['mode'];
    $cemp_url = plugins_url('', __DIR__ );
    $js_variables = '<script>
                      var cempUrl = "'.$cemp_url.'";
                      var cempPass = "'. $cemp_pass .'"; '.
                      'var cempTerms = "'. $terms .'"; '.
                      'var cempPoli = "'. $poli .'"; '.
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
      add_action('wp_enqueue_scripts','add_cemp_settings_script', 10, 1);
      add_action('wp_enqueue_scripts','add_cemp_logout_script', 10, 1);

      has_user_chat($admins);
      register_users();
    }

    // Save settings
    if($changes == 'true'){
      cemp_save_settings($access, $mode);
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

    $user_list = '<div id="cemp-list"></div>';

    $login = '<div id="cemp-config-page" class="cemp-d-none"></div>';

    $settings = '<form id="cemp-user-data">
                  <label id="cemp-error-message"></label>
                  <input class="cemp-form-input" name="log" type="text" placeholder="Usuario" required/>
                  <input class="cemp-form-input" name="pwd" type="text" placeholder="Contraseña" required/>
                  <button class="success btn cemp-form-input mt-5" onclick="">Actualizar</button>

                  <p class="mt-5">¿Cerrar sesión? <a href="'.wp_logout_url().'" >Salir</a></p>
                </form>';

    return '<div style="height:100vh;"></div>
            <div id="cemp-page">'.
              $login.
              '<div id="cemp-div" class="cemp-fade-in" style="opacity:0;">'.
                $user_list.
                '<div id="cemp-chat-div">
                  <div id="cemp-chat-info" class="bg-personalized color-personalized">
                    <i id="cemp-list-display" class="fa fa-chevron-left cemp-list-icons"></i>
                    <i id="cemp-settings-icon" class="fas fa-ellipsis-v cemp-list-icons" onclick="cempShowSettings()"></i>
                    <div id="cemp-chat-name"></div>
                    <div id="chat-settings">'.
                    $settings.
                    '</div>
                  </div>
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
