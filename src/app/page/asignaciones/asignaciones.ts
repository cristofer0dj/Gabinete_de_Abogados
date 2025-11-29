import { Component } from '@angular/core';
import { Menu } from '../../component/menu/menu';
import { AsignarAbogadosComponent } from '../../component/asignaciones/asignar-abogados/asignar-abogados';
import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-asignaciones',
  standalone: true,
  imports: [CommonModule, Menu, AsignarAbogadosComponent],
  templateUrl: './asignaciones.html',
  styleUrls: ['./asignaciones.css'],
})
export class AsignacionesComponent {

}