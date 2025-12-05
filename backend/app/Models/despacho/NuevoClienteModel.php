<?php
namespace App\Models\despacho;
use CodeIgniter\Model;

fetch('http://localhost/backend/public/despacho/nuevo_cliente', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        nombre: 'Maria',
        apellido: 'Gonzalez',
        telefono: '7890-1234',
        email: 'maria@email.com'
    })
})
.then(response => response.json())
.then(data => console.log(data));