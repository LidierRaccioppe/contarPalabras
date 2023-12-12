<?php
/*
Plugin Name: Contar Palabras
Description: Plugin para contar palabras en el título y contenido de un post en WordPress.
Version: 1.0
Author: Lidier Máximo López Raccioppe
*/

// Acción de activación del plugin
register_activation_hook(__FILE__, 'contar_palabras_instalar');

// Acción al guardar un post
add_action('publish_post', 'contar_palabras_guardar');

// Acción para mostrar la cantidad de palabras al final de un post
add_filter('the_content', 'contar_palabras_mostrar');
add_filter('the_title', 'contar_palabras_mostrar_titulo');

// Función de activación: crea la tabla
function contar_palabras_instalar() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contar_palabras';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        post_id BIGINT(20) NOT NULL,
        palabras_contenido INT,
        palabras_titulo INT,
        PRIMARY KEY (post_id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($sql);
}

// Cuenta y guarda las palabras al publicar un post
function contar_palabras_guardar($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Obtener el contenido y título del post
    $contenido = get_post_field('post_content', $post_id);
    $titulo = get_post_field('post_title', $post_id);
    // Contar palabras en el contenido y título
    $palabras_contenido = contar_palabras($contenido);
    $palabras_titulo = contar_palabras($titulo);

    // Guardar en la tabla
    global $wpdb;
    $table_name = $wpdb->prefix . 'contar_palabras';

    $wpdb->insert(
        $table_name,
        array(
            'post_id' => $post_id,
            'palabras_contenido' => $palabras_contenido,
            'palabras_titulo' => $palabras_titulo,
        ),
        array('%d', '%d', '%d')
    );
}
// Función para mostrar la cantidad de palabras al final de un post
function contar_palabras_mostrar($content) {
    $post_id = get_the_ID();
    global $wpdb;
    $table_name = $wpdb->prefix . 'contar_palabras';
    $result = $wpdb->get_row("SELECT palabras_contenido FROM $table_name WHERE post_id = $post_id");

    if ($result !== null and $result->palabras_contenido > 0) {
        $mensaje = "<p>Cantidad de palabras en el contenido: {$result->palabras_contenido}</p>";

        // inecesario despues del cambio a los acciones
        // $entrada = get_post($post_id);
        // wp_update_post($entrada);

        return $content . $mensaje;
    }

    return $content;
}

// Función para mostrar la cantidad de palabras en el título
function contar_palabras_mostrar_titulo($title) {
    $post_id = get_the_ID();
    global $wpdb;
    $table_name = $wpdb->prefix . 'contar_palabras';
    $result = $wpdb->get_row("SELECT palabras_titulo FROM $table_name WHERE post_id = $post_id");

    // el wordprees no deja publicar ninguna post sin post
    if ($result !== null and $result->palabras_titulo > 0){
        $mensaje = "<p>Cantidad de palabras en el título: {$result->palabras_titulo}</p>";

        // $entrada = get_post($post_id);
        // wp_update_post($entrada);

        return $title . $mensaje;
    }

    return $title;
}

// Función para contar palabras
function contar_palabras($texto) {
    $palabras = preg_split('/[\s.]+/', strip_tags($texto), null, PREG_SPLIT_NO_EMPTY);
    return count($palabras);
}


