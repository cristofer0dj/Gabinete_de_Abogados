import { Routes } from '@angular/router';
import { Clientes } from './page/clientes/clientes';
import { Asuntos } from './page/asuntos/asuntos';
import { Inicio } from './page/inicio/inicio';
import { Abogados } from './page/abogados/abogados';

export const routes: Routes = [
    { path: '', component: Inicio },
    { path: 'clientes', component: Clientes },
    { path: 'asuntos', component: Asuntos },
    { path: 'abogados', component: Abogados },
    

];
    