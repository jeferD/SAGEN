import { Routes } from '@angular/router';
import { inject } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from './services/auth.service';
import { KeycloakService } from './services/keycloak.service';

// Functional Guards
export const authGuard = () => {
  const authService = inject(AuthService);
  const keycloakService = inject(KeycloakService);

  if (authService.isAuthenticated()) {
    return true;
  }
  
  // Redirigir al portal SSO corporativo solo si no ocurrió un fallo crítico previo
  if (!keycloakService.initError()) {
    authService.loginWithKeycloak();
  }
  return false;
};

export const tesoreriaRoleGuard = () => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (!authService.isAuthenticated()) {
    return false;
  }

  if (authService.hasTesoreriaRole()) {
    return true;
  }

  return router.createUrlTree(['/acceso-denegado']);
};

export const roleGuard = (allowedRole: number) => {
  return () => {
    const authService = inject(AuthService);
    const router = inject(Router);
    const role = authService.userRole();

    if (role === allowedRole) {
      return true;
    }
    
    // Redirect to fallback dashboard based on current role
    if (role === 1) {
      return router.createUrlTree(['/admin/inicio']);
    } else if (role === 2) {
      return router.createUrlTree(['/pqrs/lista']);
    }
    authService.loginWithKeycloak();
    return false;
  };
};

export const routes: Routes = [
  {
    path: 'login',
    redirectTo: () => {
      const authService = inject(AuthService);
      if (authService.isAuthenticated() && !authService.hasTesoreriaRole()) {
        return '/acceso-denegado';
      }
      return '/admin/inicio';
    }
  },
  {
    path: 'acceso-denegado',
    loadComponent: () => import('./pages/acceso-denegado/acceso-denegado.component').then(m => m.AccesoDenegadoComponent)
  },
  
  // Admin Portal (Tesoreria - Role 1)
  {
    path: 'admin',
    loadComponent: () => import('./components/layout/layout.component').then(m => m.LayoutComponent),
    canActivate: [authGuard, tesoreriaRoleGuard],
    children: [
      {
        path: 'inicio',
        loadComponent: () => import('./pages/admin-inicio/admin-inicio.component').then(m => m.AdminInicioComponent)
      },
      
      // Recobros routes
      {
        path: 'recobros/nit-cuenta',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'recobros/nit-factura',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'recobros/radicado',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      
      // Cartera routes
      {
        path: 'cartera/nit-periodo',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'cartera/nit-cuenta',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'cartera/lista-radicados',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },

      // Tesoreria routes
      {
        path: 'tesoreria/nit-periodo',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'tesoreria/nit-cuenta',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'tesoreria/nit-documento',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'tesoreria/lista-radicados',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },

      // Impuestos routes
      {
        path: 'impuestos/nit-periodo',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'impuestos/nit-cuenta',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'impuestos/nit-documento',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'impuestos/lista-radicados',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },

      // Circular 030 routes
      {
        path: 'circular030/fepa',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },
      {
        path: 'circular030/cruce',
        loadComponent: () => import('./pages/query-reports/query-reports.component').then(m => m.QueryReportsComponent)
      },

      // Cubos route
      {
        path: 'cubos',
        loadComponent: () => import('./pages/dashboard-cubos/dashboard-cubos.component').then(m => m.DashboardCubosComponent)
      },

      // Emails CRUD
      {
        path: 'emails',
        loadComponent: () => import('./pages/emails-crud/emails-crud.component').then(m => m.EmailsCrudComponent)
      },
      
      { path: '', redirectTo: 'inicio', pathMatch: 'full' }
    ]
  },

  // PQRS Portal (Gestor - Role 2)
  {
    path: 'pqrs',
    loadComponent: () => import('./components/layout/layout.component').then(m => m.LayoutComponent),
    canActivate: [authGuard, roleGuard(2)],
    children: [
      {
        path: 'lista',
        loadComponent: () => import('./pages/pqrs-portal/pqrs-list/pqrs-list.component').then(m => m.PqrsListComponent)
      },
      {
        path: 'crear',
        loadComponent: () => import('./pages/pqrs-portal/pqrs-form/pqrs-form.component').then(m => m.PqrsFormComponent)
      },
      {
        path: 'actualizar/:id',
        loadComponent: () => import('./pages/pqrs-portal/pqrs-form/pqrs-form.component').then(m => m.PqrsFormComponent)
      },
      {
        path: 'visualizar/:id',
        loadComponent: () => import('./pages/pqrs-portal/pqrs-detail/pqrs-detail.component').then(m => m.PqrsDetailComponent)
      },
      { path: '', redirectTo: 'lista', pathMatch: 'full' }
    ]
  },

  // Root redirect
  {
    path: '',
    redirectTo: () => {
      const authService = inject(AuthService);
      if (authService.isAuthenticated() && !authService.hasTesoreriaRole()) {
        return '/acceso-denegado';
      }
      return '/admin/inicio';
    },
    pathMatch: 'full'
  },
  
  // Wildcard fallback
  { path: '**', redirectTo: '' }
];
