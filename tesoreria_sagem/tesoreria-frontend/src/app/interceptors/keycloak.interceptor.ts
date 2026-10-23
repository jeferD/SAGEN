import { HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { KeycloakService } from '../services/keycloak.service';
import { from, switchMap } from 'rxjs';

/**
 * Interceptor HTTP que adjunta automáticamente el token Bearer de Keycloak
 * a todas las peticiones salientes cuando el usuario está autenticado.
 */
export const keycloakInterceptor: HttpInterceptorFn = (req, next) => {
  const keycloakService = inject(KeycloakService);

  if (keycloakService.isLoggedIn()) {
    return from(keycloakService.getToken()).pipe(
      switchMap(token => {
        if (token) {
          const authReq = req.clone({
            setHeaders: {
              Authorization: `Bearer ${token}`
            }
          });
          return next(authReq);
        }
        return next(req);
      })
    );
  }

  return next(req);
};
