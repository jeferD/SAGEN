import { ApplicationConfig, InjectionToken, APP_INITIALIZER, provideBrowserGlobalErrorListeners, provideZoneChangeDetection } from '@angular/core';
import { provideHttpClient, withInterceptors } from '@angular/common/http';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';
import { KeycloakService } from './services/keycloak.service';
import { AuthService } from './services/auth.service';
import { keycloakInterceptor } from './interceptors/keycloak.interceptor';

export const API_BASE_URL = new InjectionToken<string>('API_BASE_URL');

export const getApiBaseUrl = (): string => {
  if (typeof window !== 'undefined') {
    // Si se corre en desarrollo local directo en localhost
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
      return 'http://192.168.125.37:9163/api/sagem/reportes';
    }
  }
  // En producción (a través del reverse proxy Nginx para evitar CORS y Mixed-Content)
  return '/api/sagem/reportes';
};

export function initializeKeycloak(keycloak: KeycloakService, auth: AuthService) {
  return () =>
    keycloak.init().then(() => {
      auth.syncFromKeycloak();
    });
}

export const appConfig: ApplicationConfig = {
  providers: [
    provideBrowserGlobalErrorListeners(),
    provideZoneChangeDetection({ eventCoalescing: true }),
    provideHttpClient(
      withInterceptors([keycloakInterceptor])
    ),
    provideRouter(routes),
    {
      provide: APP_INITIALIZER,
      useFactory: initializeKeycloak,
      multi: true,
      deps: [KeycloakService, AuthService]
    },
    {
      provide: API_BASE_URL,
      useFactory: getApiBaseUrl
    }
  ]
};
