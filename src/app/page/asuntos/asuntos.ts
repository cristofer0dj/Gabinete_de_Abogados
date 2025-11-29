import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Menu } from '../../component/menu/menu';
import { ListaAsuntos } from '../../component/asuntos/lista-asuntos/lista-asuntos';
import { FormAsunto } from '../../component/asuntos/form-asunto/form-asunto';

  
@Component({
  selector: 'app-asuntos',
  standalone: true,
  imports: [CommonModule, Menu, ListaAsuntos, FormAsunto],
  templateUrl: './asuntos.html',
  styleUrls: ['./asuntos.css'],
})
export class Asuntos {
  lista: boolean = true;

  mostrar() {
    this.lista = !this.lista;
  }

  recargar() {
    this.mostrar();
  }
}