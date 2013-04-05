<?php
/*
Plugin Name: Vitrine Mercado Livre
Plugin URI: http://aleborba.com.br
Description: Este plugin implementa uma vitrine ao seu wordpress.
Version: 0.1.0
Author: Alê Borba
Author URI: http://profiles.wordpress.org/ale_borba/
License: GPL2
*/

require_once "php-sdk/src/meli.php";

$meli = new Meli(array(
    'appId'     => '6687044510288187', 
    'secret'    => 'lf6qiHrVjmnOC0knTxaH43OJkYOXF5Ht',
));

$userID = $meli->initConnect();

if (!$userID) { ?>

  <div>
   <p> Login using OAuth 2.0 handled by the PHP SDK: </p>
    <a href="<?php echo $meli->getLoginUrl(); ?>">Login with MercadoLibre</a>
  </div>

<?php
}

function vitrine_mercadolivre($args) {
    
    $meli = new Meli(array(
        'appId'     => '6687044510288187', 
        'secret'    => 'lf6qiHrVjmnOC0knTxaH43OJkYOXF5Ht',
    ));

    $userID = $meli->initConnect();
    
    $items = $meli->getWithAccessToken("/users/{$userID}/items/search?status=active");
    $infos = array();

    foreach ($items['json']['results'] as $item) {
        $fullFeed = $meli->get('/items/'.$item);
        $infos[$item] = $fullFeed['json'];
    }

    #$options = get_option('vitrine_mercadolivre');

    print $args['before_widget'];
    print $args['before_title']."Vitrine Mercado Livre".$args['after_title'];
    print "<div style='text-align:center;margin:0 auto;'>";

    foreach ($infos as $info) {

        print "<div style='font-size: 15px;font-family:Arial;font-weight:bold;'>".$info['title']."</div>";
        print "<a href='".$info['permalink']."' title='".$info['title']."' target='blank_'><img src=".$info['thumbnail']."/></a><br />";
        print "<div style='margin-bottom:10px;'>R$ ".$info['price'].",00</div>";
    }
    print "</div>";
    print $args['after_widget'];
}

function vitrine_mercadolivre_cadastro() {

    $meli = new Meli(array(
        'appId'     => '6687044510288187', 
        'secret'    => 'lf6qiHrVjmnOC0knTxaH43OJkYOXF5Ht',
    ));

    $userID = $meli->initConnect();

    if ($_POST['cadastrar_produto']) {

        $params['title'] = $_POST['title'];
        $params['category_id'] = $_POST['category_id'];
        $params['price'] = intval($_POST['price']);
        $params['currency_id'] = "BRL";
        $params['available_quantity'] = intval($_POST['available_quantity']);
        $params['buying_mode'] = "buy_it_now";
        $params['listing_type_id'] = $_POST['listing_type_id'];
        $params['condition'] = $_POST['condition'];
        $params['description'] = $_POST['description'];
        $params['pictures'][0]['source'] = $_POST['pictures'];

        $response = $meli->postWithAccessToken("/items/", $params);
    }
     ?>
        <div style="width:500px;">
            <form name="cadastrar_produto" method="post" action="">
                <input type="hidden" name="cadastrar_produto" value="1" />
                <p>
                    <label for="title">Nome do Produto:</label>
                    <input type="text" name="title" maxlength="150" value="" class="widefat" />
                </p>
                <p>
                    <label for="category_id">Categoria:</label>
                    <input type="text" name="category_id" maxlength="50" value="" class="widefat" />
                </p>
                <p>
                    <label for="price">Preço:</label>
                    <input type="text" name="price" maxlength="50" value="" class="widefat" />
                </p>
                <p>
                    <label for="available_quantity">Quantidade:</label>
                    <input type="text" name="available_quantity" maxlength="2" value="" class="widefat" />
                </p>
                <p>
                    <label for="listing_type_id">Tipo de Anúncio:</label>
                    <input type="text" name="listing_type_id" maxlength="50" value="" class="widefat" />
                </p>
                <p>
                    <label for="condition">Status:</label>
                    <input type="text" name="condition" maxlength="50" value="" class="widefat" />
                </p>
                <p>
                    <label for="description">Descrição:</label>
                    <input type="text" name="description" maxlength="255" value="" class="widefat" />
                </p>
                <p>
                    <label for="pictures">Imagem:</label>
                    <input type="text" name="pictures" maxlength="255" value="" class="widefat" />
                </p>
                <p class="submit">
                    <input type="submit" name="Salvar" class="button-primary" value="<?php esc_attr_e('Salvar') ?>" />
                </p>
            </form>
        <div style="width:500px;">
    <?php
}

function vitrine_mercadolivre_admin() {
    add_menu_page("Admin Mercado Livre", "Vitrine MeLi", 'manage_options', 'admin-vitrine-ml', 'vitrine_mercadolivre_cadastro');
}

function vitrine_mercadolivre_widgets() {
    register_sidebar_widget('Vitrine Mercado Livre', vitrine_mercadolivre);
}

// Carregar o widget
add_action('widgets_init', 'vitrine_mercadolivre_widgets');
add_action('admin_menu', 'vitrine_mercadolivre_admin'); 

/*  Copyright 2013  Alê Borba  (email : ale.alvesborba@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

    {"id":135418342,
    "nickname":"TT167707",
    "password":"qatest8136",
    "site_status":"active",
    "email":"test_user_1512922@testuser.com"}


var_dump($userID);

if ($userID) {
    $user = $meli->getAccessToken();

    echo "<pre>";
    print_r($user);
}

else{ ?>

      <div>
       <p> Login using OAuth 2.0 handled by the PHP SDK: </p>
        <a href="<?php echo $meli->getLoginUrl(); ?>">Login with MercadoLibre</a>
      </div>
<?php
}
*/