import { Component, OnInit } from '@angular/core';
import { Subscription } from 'rxjs';
import { Alert } from '../alert';
import { AuthService } from '../auth/auth.service';
import { AlertService } from '../alert.service';

@Component({
  selector: 'app-public',
  // We'll use an external file for both the CSS styles and HTML view
  templateUrl: 'public.component.html',
  styleUrls: ['public.component.css']
})
export class PublicComponent implements OnInit {
  alertsSub: Subscription;
  error: any;

  // Note: We haven't implemented the Deal or Auth Services yet.
  constructor(
    public alertService: AlertService,
    public authService: AuthService
  ) { }

  // When this component is loaded, we'll call the dealService and get our public deals.
  ngOnInit() {
  }

}