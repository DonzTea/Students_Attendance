<?php

Route::get('/', function () {
    return redirect(route('admin.dashboard'));
});

Route::get('home', function () {
    return redirect(route('admin.dashboard'));
});

Route::name('admin.')->prefix('admin')->middleware('auth')->group(function () {
    Route::get('dashboard', 'DashboardController')->name('dashboard');
    Route::get('dashboard/add-new-school-year', 'DashboardController@addNewSchoolYear')->name('dashboard.new_school_year');

    Route::get('users/roles', 'UserController@roles')->name('users.roles');
    Route::resource('users', 'UserController')->except([
        'create', 'store', 'show',
    ]);

    Route::get('teachers/all-data', 'TeacherController@getAllData')->name('teachers.allData');
    Route::get('teachers/class/{id}', 'TeacherController@teachersClass')->name('teachers.class');
    Route::get('teachers/class/{id}/data', 'TeacherController@getClassData')->name('teachers.classData');
    Route::resource('teachers', 'TeacherController');

    Route::get('students/all-data', 'StudentController@getAllData')->name('students.allData');
    Route::get('students/class/{id}', 'StudentController@studentsClass')->name('students.class');
    Route::get('students/class/{id}/data', 'StudentController@getClassData')->name('students.classData');
    Route::get('students/class/{id}/presence/{date}', 'StudentController@studentsClassPresence')->name('students.class.presence');
    Route::resource('students', 'StudentController');

    Route::get('parents/all-data', 'StudentParentController@allParents')->name('parents.all');
    Route::resource('parents', 'StudentParentController');

    Route::get('presences/', 'PresenceController@index')->name('presences.index');
    Route::get('presences/class/{id}/month/{month}', 'PresenceController@show')->name('presences.show');
    Route::get('presences/class/{id}/date/{date}/create-or-edit', 'PresenceController@createOrEdit')->name('presences.createOrEdit');
    Route::post('presences/class/{id}/date/{date}', 'PresenceController@store')->name('presences.store');
    Route::put('presences/class/{id}/date/{date}', 'PresenceController@update')->name('presences.update');
    Route::delete('presences/class/{id}/date/{date}', 'PresenceController@destroy')->name('presences.destroy');
    Route::get('presences/class/{id}/date/{date}/export', 'PresenceController@export')->name('presences.export');

    Route::get('history-teachers/school-years', 'HistoryTeacherController@schoolYears')->name('historyTeachers.schoolYears');
    Route::get('history-teachers/school-year/{id}', 'HistoryTeacherController@index')->name('historyTeachers.index');
    Route::get('history-teachers/school-year/{id}/all-data', 'HistoryTeacherController@getSchoolYearData')->name('historyTeachers.schoolYearData');
    Route::get('history-teachers/school-year/{year_id}/class/{class_id}', 'HistoryTeacherController@historyTeachersSchoolYearClass')->name('historyTeachers.schoolYearClass');
    Route::get('history-teachers/school-year/{year_id}/class/{class_id}/data', 'HistoryTeacherController@getSchoolYearClassData')->name('historyTeachers.schoolYearClassData');
    Route::get('history-teachers/{teacher_id}/school-year/{year_id}', 'HistoryTeacherController@show')->name('historyTeachers.show');

    Route::get('history-students/school-years', 'HistoryStudentController@schoolYears')->name('historyStudents.schoolYears');
    Route::get('history-students/school-year/{id}', 'HistoryStudentController@index')->name('historyStudents.index');
    Route::get('history-students/school-year/{id}/all-data', 'HistoryStudentController@getSchoolYearData')->name('historyStudents.schoolYearData');
    Route::get('history-students/school-year/{year_id}/class/{class_id}', 'HistoryStudentController@historyStudentsSchoolYearClass')->name('historyStudents.schoolYearClass');
    Route::get('history-students/school-year/{year_id}/class/{class_id}/data', 'HistoryStudentController@getSchoolYearClassData')->name('historyStudents.schoolYearClassData');
    Route::get('history-students/{student_id}/school-year/{year_id}', 'HistoryStudentController@show')->name('historyStudents.show');

    Route::get('history-presences/school-years', 'HistoryPresenceController@schoolYears')->name('historyPresences.schoolYears');
    Route::get('history-presences/school-year/{id}', 'HistoryPresenceController@historyPresencesIndex')->name('historyPresences.index');
    Route::get('history-presences/school-year/{id}/class/{class_id}/months', 'HistoryPresenceController@historyPresencesMonths')->name('historyPresences.months');
    Route::get('history-presences/school-year/{id}/class/{class_id}/month/{month}', 'HistoryPresenceController@historyPresencesMonth')->name('historyPresences.month');
    Route::get('history-presences/school-year/{id}/class/{class_id}/month/{month}/export', 'HistoryPresenceController@export')->name('historyPresences.export');
});

Route::middleware('auth')->get('logout', function () {
    Auth::logout();
    return redirect(route('login'))->withInfo('Logout berhasil!');
})->name('logout');

Auth::routes(['verify' => true]);

Route::name('js.')->group(function () {
    Route::get('dynamic.js', 'JsController@dynamic')->name('dynamic');
});

// Get authenticated user
Route::get('users/auth', function () {
    return response()->json(['user' => Auth::check() ? Auth::user() : false]);
});
