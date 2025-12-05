import { Component } from '@angular/core';
import { Menu } from '../../component/menu/menu';
import { AsignarAbogadosComponent } from '../../component/asignaciones/asignar-abogados/asignar-abogados';
import { ListaAsignaciones } from '../../component/asignaciones/lista-asignaciones/lista-asignaciones';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-asignaciones',
  standalone: true,
  imports: [CommonModule, Menu, AsignarAbogadosComponent, ListaAsignaciones],
  templateUrl: './asignaciones.html',
  styleUrls: ['./asignaciones.css'],
})
export class AsignacionesComponent {
  lista: boolean = true;
  listaComponent: ListaAsignaciones | null = null;

  mostrar() {
    this.lista = !this.lista;
  }

  recargar() {
    this.mostrar();
  }
}