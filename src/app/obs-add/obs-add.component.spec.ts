import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ObsAddComponent } from './obs-add.component';

describe('ObsAddComponent', () => {
  let component: ObsAddComponent;
  let fixture: ComponentFixture<ObsAddComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ObsAddComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ObsAddComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
