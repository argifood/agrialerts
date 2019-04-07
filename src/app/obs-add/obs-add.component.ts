import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormControl, FormGroup,  FormBuilder, FormArray, Validators } from '@angular/forms';
import { Subscription } from 'rxjs';
import { Ob } from '../ob';
import { Obdim } from '../obdim';
import { Alerttype } from '../alerttype';
import { Agritype } from '../agritype';
import { Nuts2 } from '../nuts2';
import { Nuts3 } from '../nuts3';
import { Nuts5 } from '../nuts5';
import { AuthService } from '../auth/auth.service';
import { ParamsService } from '../params.service';
import { ObService } from '../ob.service';

@Component({
  selector: 'app-obs-add',
  templateUrl: './obs-add.component.html',
  styleUrls: ['./obs-add.component.css']
})
export class ObsAddComponent implements OnInit {
  alerttypeSub: Subscription;
  agritypeSub: Subscription;
  nuts2Sub: Subscription;
  nuts3Sub: Subscription;
  nuts5Sub: Subscription;
  obSub: Subscription;
  obdimSub: Subscription;
  newOb: Ob;
  alerttypes: Alerttype[];
  agritypes: Agritype[];
  nuts2s: Nuts2[];
  nuts3s: Nuts3[];
  nuts5s: Nuts5[];
  error: any;

	addObForm = this.fb.group({
		observation_name:  ['', Validators.required],
		observation_date:  ['', Validators.required],
	  alerttype_id:   ['', Validators.required],
	  agritype_id:   ['', Validators.required],
	  agri_dim_severity: [''],
	  nuts2_id:   ['', Validators.required],
	  nuts3_id: [''],
	  nuts5_id: ['']
		
	});
	
	nuts2Change(event: any){
		let n2 = event.target.value;
		this.nuts3Sub = this.paramsService
		.getNuts3(n2)
		.subscribe(
			nuts3s => this.nuts3s = nuts3s,
			err => this.error = err
		);
		
	}
	
	nuts3Change(event: any){
		let n3 = event.target.value;
		this.nuts5Sub = this.paramsService
		.getNuts5(n3)
		.subscribe(
			nuts5s => this.nuts5s = nuts5s,
			err => this.error = err
		);
		
	}

	onSubmit(ob: any){
		ob.user_ext_id = this.authService.userID;
		console.log("ob submitted: " + JSON.stringify(ob));
		const newObserver = {
			next: newOb => console.log("new Ob:" + newOb),
			complete: (result) => {
				ob.observation_id = 2;
				this.obdimSub = this.obService.addObdim(JSON.stringify(ob)).subscribe();
			},
		};
		this.obSub = this.obService.addOb(JSON.stringify(ob)).subscribe(newObserver);

	}

  constructor(
		private fb: FormBuilder,
		public obService: ObService,
		public paramsService: ParamsService,
		public authService: AuthService
		
	) { }

  ngOnInit() {
    this.alerttypeSub = this.paramsService
      .getAlerttypes()
      .subscribe(
        alerttypes => this.alerttypes = alerttypes,
        err => this.error = err
      );

    this.agritypeSub = this.paramsService
      .getAgritypes()
      .subscribe(
        agritypes => this.agritypes = agritypes,
        err => this.error = err
      );

	this.nuts2Sub = this.paramsService
      .getNuts2()
      .subscribe(
        nuts2s => this.nuts2s = nuts2s,
        err => this.error = err
      );
  }

  ngOnDestroy() {
    this.alerttypeSub.unsubscribe();
	this.agritypeSub.unsubscribe();
    this.nuts2Sub.unsubscribe();
  }
}
