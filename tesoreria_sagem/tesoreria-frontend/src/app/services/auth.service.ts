import { Injectable, signal, computed } from '@angular/core';
import { Router } from '@angular/router';

export interface UserSession {
  username: string;
  name: string;
  role: number; // 1 = Tesoreria Admin, 2 = PQRS Gestor
  empId?: string;
  noId?: string;
}

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private readonly SESSION_KEY = 'sagem_user_session';
  
  // Reactive session state using signals
  private sessionState = signal<UserSession | null>(this.loadSessionFromStorage());

  public readonly currentUser = computed(() => this.sessionState());
  public readonly isAuthenticated = computed(() => this.sessionState() !== null);
  public readonly userRole = computed(() => this.sessionState()?.role ?? null);

  constructor(private router: Router) {}

  private loadSessionFromStorage(): UserSession | null {
    try {
      const data = localStorage.getItem(this.SESSION_KEY);
      return data ? JSON.parse(data) : null;
    } catch {
      return null;
    }
  }

  public login(user: string, pass: string): boolean {
    const username = user.trim().toLowerCase();
    
    // Simulate user accounts based on role mappings in conexion.php
    let session: UserSession | null = null;
    
    if (username === 'admin' && pass === '123456') {
      session = {
        username: 'admin',
        name: 'Administrador de Tesorería',
        role: 1,
        empId: 'EMP001',
        noId: '101010'
      };
    } else if (username === 'pqrs' && pass === '123456') {
      session = {
        username: 'pqrs',
        name: 'Gestor de PQRS',
        role: 2,
        empId: 'EMP002',
        noId: '202020'
      };
    }

    if (session) {
      this.sessionState.set(session);
      localStorage.setItem(this.SESSION_KEY, JSON.stringify(session));
      return true;
    }
    
    return false;
  }

  public logout(): void {
    this.sessionState.set(null);
    localStorage.removeItem(this.SESSION_KEY);
    this.router.navigate(['/login']);
  }

  public recuperarClave(noId: string): string | null {
    // Simulates registros_db/clases/conexion.php's recuperar method
    if (noId === '101010') {
      return 'bryanacosta@emssanar.org.co';
    } else if (noId === '202020') {
      return 'pqrs@emssanar.org.co';
    }
    return null;
  }
}
