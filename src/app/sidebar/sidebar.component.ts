import { Component, OnInit, OnDestroy } from '@angular/core';
import { Subscription } from 'rxjs';
import { Alert } from '../alert';
import { AuthService } from '../auth/auth.service';
import { AlertService } from '../alert.service';

@Component({
  selector: 'app-private',
    templateUrl: './sidebar.component.html',
    styleUrls: ['./sidebar.component.css'],
})
export class SidebarComponent {
  alertsSub: Subscription;
  privateAlerts: Alert[];
  error: any;
  title = 'agrialerts';

  constructor(
    public alertService: AlertService,
      public authService: AuthService
    ) { }

  ngOnInit() {
    this.alertsSub = this.alertService
        .getPrivate()
        .subscribe(
          alerts => this.privateAlerts = alerts,
          err => this.error = err
        );
  }

  ngOnDestroy() {
    this.alertsSub.unsubscribe();
  }
}
