<?php


fetch('http://localhost/backend/public/despacho/nuevo_asunto', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({
        expediente: 'EXP-2025-005',
        descripcion: 'Caso de propiedad intelectual',
        estado: 'En proceso',
        fechainicio: '2025-10-31',
        fechafin: '2025-12-31',
        idcliente: 1
    })
})
.then(response => response.json())
.then(data => console.log(data));