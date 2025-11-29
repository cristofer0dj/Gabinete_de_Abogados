import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-menu',
  standalone: true,
  imports: [],
  templateUrl: './menu.html',
  styleUrls: ['./menu.css'],
})
export class Menu {
  @Input() activo: number = 0;
}
