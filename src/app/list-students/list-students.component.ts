import { Component, OnInit } from '@angular/core';
import { StudentsService } from '../students.service';

@Component({
  selector: 'app-list-students',
  templateUrl: './list-students.component.html',
  styleUrls: ['./list-students.component.css']
})
export class ListStudentsComponent implements OnInit {
  students: any;

  constructor(private studentservice: StudentsService) { }

  ngOnInit(): void {
    this.studentservice.getStudents().subscribe(
      (data:any)=>{
        this.students = data.record;
      }
    )
  }
  deleteStudent(id:any)
  {
    this.studentservice.deleteStudent(id).subscribe(
      (data:any)=>{
        if(data.status=='success')
        {
          alert('Record Delete successfully.');
        }else{
          alert('Record Not Deleted.');
        }
        location.reload();
      }
    )
  }
}
