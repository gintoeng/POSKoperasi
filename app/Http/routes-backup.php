<?php


/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web'] ], function () {

    Route::group(['middleware' => ['auth'] ], function () {

        Route::group(['middleware' => ['rkoperasi'] ], function () {

            Route::get('account', 'Account\AccountController@showAccount');
            Route::post('account/update', 'Account\AccountController@updateAccount');

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            Route::group(['prefix' => 'pengaturan'], function () {

                Route::group(['prefix' => 'customer'], function () {
                    Route::get('aksesttp', 'Master\CustomerController@aksesttp');
                    Route::post('aksesttp', 'Master\CustomerController@postaksesttp');
                    Route::get('aksesttp/delete/{id}', 'Master\CustomerController@destroyakses');
                });
                Route::group(['prefix' => 'backup-restore'], function () {
                    Route::get('', 'Pengaturan\BackupRestoreController@index');
                    Route::get('backup', 'Pengaturan\BackupRestoreController@backup');
                    Route::get('backup/download', 'Pengaturan\BackupRestoreController@dackupdown');
                    Route::post('restore', 'Pengaturan\BackupRestoreController@postrestore');
                    Route::post('restore/local', 'Pengaturan\BackupRestoreController@postrestorelocal');
                });

                Route::group(['prefix' => 'approve'], function () {
                    Route::group(['prefix' => 'simpanan'], function () {
                        Route::group(['middleware' => 'role:pengaturan/approve/simpanan'], function () {
                            Route::get('', 'Pengaturan\ApproveController@index_simpanan');
                            Route::get('search', 'Pengaturan\ApproveController@search_simpanan');
                        });
                    });
                    Route::group(['prefix' => 'pinjaman'], function () {
                        Route::group(['middleware' => 'role:pengaturan/approve/pinjaman'], function () {
                            Route::get('', 'Pengaturan\ApproveController@index_pinjaman');
                            Route::get('search', 'Pengaturan\ApproveController@search_pinjaman');
                        });
                    });
                    Route::group(['prefix' => 'waserda'], function () {
                        Route::group(['middleware' => 'role:pengaturan/approve/waserda'], function () {
                            Route::get('', 'Pengaturan\ApproveController@index_waserda');
                            Route::get('search', 'Pengaturan\ApproveController@search_waserda');
                        });
                    });
                    Route::get('lev1/{id}', 'Pengaturan\ApproveController@level1');
                    Route::get('lev2/{id}', 'Pengaturan\ApproveController@level2');
                    Route::get('lev3/{id}', 'Pengaturan\ApproveController@level3');
                    Route::get('rel/{id}', 'Pengaturan\ApproveController@release');
                });

                Route::group(['prefix' => 'user'], function () {
                    Route::get('ajax/{rid}', 'Users\UserController@ajax');
                    Route::group(['middleware' => 'role:pengaturan/user'], function () {
                        Route::get('', 'Users\UserController@getUser');
                        Route::get('search', 'Users\UserController@searchUser');
                    });
                    Route::group(['middleware' => 'rolec:pengaturan/user'], function () {
                        Route::get('add', 'Users\UserController@addUser');
                        Route::post('add', 'Users\UserController@postUser');
                    });
                    Route::group(['middleware' => 'roleu:pengaturan/user'], function () {
                        Route::get('data/{id}', 'Users\UserController@showUser');
                        Route::post('update', 'Users\UserController@updateUser');
                    });
                    Route::group(['middleware' => 'roled:pengaturan/user'], function () {
                        Route::get('delete/{id}', 'Users\UserController@deleteUser');
                    });
                });

                Route::group(['prefix' => 'nomor'], function () {
                    Route::group(['middleware' => 'role:pengaturan/nomor'], function () {
                        Route::get('', 'Pengaturan\NomorController@index');
                        Route::get('search', 'Pengaturan\NomorController@search');
                    });
                    Route::group(['middleware' => 'rolec:pengaturan/nomor'], function () {
                        Route::get('create', 'Pengaturan\NomorController@create');
                        Route::post('', 'Pengaturan\NomorController@store');
                    });
                    Route::group(['middleware' => 'roleu:pengaturan/nomor'], function () {
                        Route::get('{id}/edit', 'Pengaturan\NomorController@edit');
                        Route::post('{id}/update', 'Pengaturan\NomorController@update');
                    });
                    Route::group(['middleware' => 'roled:pengaturan/nomor'], function () {
                        Route::get('{id}/destroy', 'Pengaturan\NomorController@destroy');
                    });
                });

                Route::group(['prefix' => 'module'], function () {
                    Route::group(['middleware' => 'role:pengaturan/module'], function () {
                        Route::get('', 'Modules\ModulesController@getIndex');
                        Route::get('search', 'Modules\ModulesController@search');
                        Route::get('order/up/{id}', 'Modules\ModulesController@up');
                        Route::get('order/down/{id}', 'Modules\ModulesController@down');
                    });
                    Route::group(['middleware' => 'rolec:pengaturan/module'], function () {
                        Route::get('add', 'Modules\ModulesController@getForm');
                        Route::post('add', 'Modules\ModulesController@save');
                    });
                    Route::group(['middleware' => 'roleu:pengaturan/module'], function () {
                        Route::get('edit/{id}', 'Modules\ModulesController@edit');
                        Route::post('edit/{id}', 'Modules\ModulesController@update');
                    });
                    Route::group(['middleware' => 'roled:pengaturan/module'], function () {
                        Route::get('delete/{id}', 'Modules\ModulesController@delete');
                    });
                });

                Route::group(['prefix' => 'role'], function () {
                    Route::group(['middleware' => 'role:pengaturan/role'], function () {
                        Route::get('', 'Role\RoleController@getIndex');
                        Route::get('search', 'Role\RoleController@search');
                    });
                    Route::group(['middleware' => 'rolec:pengaturan/role'], function () {
                        Route::get('add', 'Role\RoleController@getForm');
                        Route::post('add', 'Role\RoleController@save');
                    });
                    Route::group(['middleware' => 'roleu:pengaturan/role'], function () {
                        Route::get('edit/{id}', 'Role\RoleController@edit');
                        Route::post('update/{id}', 'Role\RoleController@update');
                    });
                    Route::group(['middleware' => 'roled:pengaturan/role'], function () {
                        Route::get('delete/{id}', 'Role\RoleController@delete');
                    });
                });

                Route::group(['middleware' => 'role:pengaturan/profil'], function () {
                    Route::resource('profil', 'Pengaturan\ProfilController', ['only' => ['index', 'store']]);
                });

            });

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            Route::group(['prefix' => 'master'], function () {

                Route::group(['prefix' => 'customer'], function () {

                    Route::group(['middleware' => 'role:master/customer'], function () {
                        Route::get('', 'Master\CustomerController@index');
                        Route::get('search', 'Master\CustomerController@search');
                        Route::get('detail/{id}', 'Master\CustomerController@show');
                    });
                    Route::group(['middleware' => 'rolec:master/customer'], function () {
                        Route::get('create', 'Master\CustomerController@create');
                        Route::post('', 'Master\CustomerController@store');
                        Route::get('import', 'Master\CustomerController@import');
                        Route::get('export', 'Master\CustomerController@export');
                        Route::post('import', 'Master\CustomerController@postimport');
                        Route::get('import/sample', 'Master\CustomerController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/customer'], function () {
                        Route::get('tutup/{id}/{status}', 'Master\CustomerController@editstatus');
                        Route::get('{id}/edit', 'Master\CustomerController@edit');
                        Route::post('{id}/update', 'Master\CustomerController@update');
                    });
                    Route::group(['middleware' => 'roled:master/customer'], function () {
//                        Route::get('tutup/{id}/{status}', 'Master\CustomerController@tutupanggota');
                        Route::get('{id}/destroy', 'Master\CustomerController@destroy');
                    });
                    Route::get('cek', 'Master\CustomerController@cekaturan');
                    Route::get('recab/{id}', 'Master\CustomerController@recab');
                    Route::get('cek/import', 'Master\CustomerController@cekaturanimport');
                    Route::get('attach/doc/{idp}', 'Attach\AttachController@ajaxdoc2');
                    Route::post('attach', 'Attach\AttachController@store2');
                    Route::get('attach/destroy/{id}/{idp}', 'Attach\AttachController@destroy2');
                    Route::get('attach/download/{id}', 'Attach\AttachController@download2');
                    Route::get('attach/preview/{id}', 'Attach\AttachController@show2');
                });

                Route::group(['prefix' => 'vendor'], function () {
                    Route::group(['middleware' => 'role:master/vendor'], function () {
                        Route::get('', 'Master\VendorController@index');
                        Route::get('search', 'Master\VendorController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/vendor'], function () {
                        Route::get('create', 'Master\VendorController@create');
                        Route::post('', 'Master\VendorController@store');
                        Route::get('import', 'Master\VendorController@import');
                        Route::get('export', 'Master\VendorController@export');
                        Route::post('import', 'Master\VendorController@postimport');
                        Route::get('import/sample', 'Master\VendorController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/vendor'], function () {
                        Route::get('{id}/edit', 'Master\VendorController@edit');
                        Route::post('{id}/update', 'Master\VendorController@update');
                    });
                    Route::group(['middleware' => 'roled:master/vendor'], function () {
                        Route::get('{id}/destroy', 'Master\VendorController@destroy');
                    });
                    Route::get('cek', 'Master\VendorController@cekaturan');
                    Route::get('ajax/{id}', 'Master\VendorController@ajax');
                    Route::get('cek2', 'Master\VendorController@cekaturan2');
                    Route::get('cek/import', 'Master\VendorController@cekaturanimport');

                });

                Route::group(['prefix' => 'barang'], function () {
                    Route::group(['middleware' => 'role:master/barang'], function () {
                        Route::get('', 'Master\BarangController@index');
                        Route::get('search', 'Master\BarangController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/barang'], function () {
                        Route::get('create', 'Master\BarangController@create');
                        Route::post('', 'Master\BarangController@store');
                        Route::get('import', 'Master\BarangController@import');
                        Route::get('export', 'Master\BarangController@export');
                        Route::post('import', 'Master\BarangController@postimport');
                        Route::get('import/sample', 'Master\BarangController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/barang'], function () {
                        Route::get('{id}/edit', 'Master\BarangController@edit');
                        Route::post('{id}/update', 'Master\BarangController@update');
                    });
                    Route::group(['middleware' => 'roled:master/barang'], function () {
                        Route::get('{id}/destroy', 'Master\BarangController@destroy');
                    });
                    Route::get('untung/{j}/{b}', 'Master\BarangController@untung');
                    Route::get('cek/import', 'Master\BarangController@cekaturanimport');
                });

                Route::group(['prefix' => 'bank'], function () {
                    Route::group(['middleware' => 'role:master/bank'], function () {
                        Route::get('', 'Master\BankController@index');
                        Route::get('search', 'Master\BankController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/bank'], function () {
                        Route::get('create', 'Master\BankController@create');
                        Route::post('', 'Master\BankController@store');
                        Route::get('import', 'Master\BankController@import');
                        Route::get('export', 'Master\BankController@export');
                        Route::post('import', 'Master\BankController@postimport');
                        Route::get('import/sample', 'Master\BankController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/bank'], function () {
                        Route::get('{id}/edit', 'Master\BankController@edit');
                        Route::post('{id}/update', 'Master\BankController@update');
                    });
                    Route::group(['middleware' => 'roled:master/bank'], function () {
                        Route::get('{id}/destroy', 'Master\BankController@destroy');
                    });
                });

                Route::group(['prefix' => 'matauang'], function () {
                    Route::group(['middleware' => 'role:master/matauang'], function () {
                        Route::get('', 'Master\MatauangController@index');
                        Route::get('search', 'Master\MatauangController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/matauang'], function () {
                        Route::get('create', 'Master\MatauangController@create');
                        Route::post('', 'Master\MatauangController@store');
                        Route::get('import', 'Master\MatauangController@import');
                        Route::get('export', 'Master\MatauangController@export');
                        Route::post('import', 'Master\MatauangController@postimport');
                        Route::get('import/sample', 'Master\MatauangController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/matauang'], function () {
                        Route::get('{id}/edit', 'Master\MatauangController@edit');
                        Route::post('{id}/update', 'Master\MatauangController@update');
                    });
                    Route::group(['middleware' => 'roled:master/matauang'], function () {
                        Route::get('{id}/destroy', 'Master\MatauangController@destroy');
                    });
                });

                Route::group(['prefix' => 'kolektibilitas'], function () {
                    Route::group(['middleware' => 'role:master/kolektibilitas'], function () {
                        Route::get('', 'Master\KolektibilitasController@index');
                        Route::get('search', 'Master\KolektibilitasController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/kolektibilitas'], function () {
                        Route::get('export', 'Master\KolektibilitasController@export');
                    });
                    Route::group(['middleware' => 'roleu:master/kolektibilitas'], function () {
                        Route::get('{id}/edit', 'Master\KolektibilitasController@edit');
                        Route::post('{id}/update', 'Master\KolektibilitasController@update');
                    });

                });

                Route::group(['prefix' => 'unit'], function () {
                    Route::group(['middleware' => 'role:master/unit'], function () {
                        Route::get('', 'Master\UnitController@index');
                        Route::get('search', 'Master\UnitController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/unit'], function () {
                        Route::get('create', 'Master\UnitController@create');
                        Route::post('', 'Master\UnitController@store');
                        Route::get('import', 'Master\UnitController@import');
                        Route::get('export', 'Master\UnitController@export');
                        Route::post('import', 'Master\UnitController@postimport');
                        Route::get('import/sample', 'Master\UnitController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/unit'], function () {
                        Route::get('{id}/edit', 'Master\UnitController@edit');
                        Route::post('{id}/update', 'Master\UnitController@update');
                    });
                    Route::group(['middleware' => 'roled:master/unit'], function () {
                        Route::get('{id}/destroy', 'Master\UnitController@destroy');
                    });
                });

                Route::group(['prefix' => 'kategori'], function () {
                    Route::group(['middleware' => 'role:master/kategori'], function () {
                        Route::get('', 'Master\KategoriController@index');
                        Route::get('search', 'Master\KategoriController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/kategori'], function () {
                        Route::get('create', 'Master\KategoriController@create');
                        Route::post('', 'Master\KategoriController@store');
                        Route::get('import', 'Master\KategoriController@import');
                        Route::get('export', 'Master\KategoriController@export');
                        Route::post('import', 'Master\KategoriController@postimport');
                        Route::get('import/sample', 'Master\KategoriController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/kategori'], function () {
                        Route::get('{id}/edit', 'Master\KategoriController@edit');
                        Route::post('{id}/update', 'Master\KategoriController@update');
                    });
                    Route::group(['middleware' => 'roled:master/kategori'], function () {
                        Route::get('{id}/destroy', 'Master\KategoriController@destroy');
                    });
                });

                Route::group(['prefix' => 'cabang'], function () {
                    Route::group(['middleware' => 'role:master/cabang'], function () {
                        Route::get('', 'Master\CabangController@index');
                        Route::get('search', 'Master\CabangController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/cabang'], function () {
                        Route::get('create', 'Master\CabangController@create');
                        Route::post('', 'Master\CabangController@store');
                        Route::get('import', 'Master\CabangController@import');
                        Route::get('export', 'Master\CabangController@export');
                        Route::post('import', 'Master\CabangController@postimport');
                        Route::get('import/sample', 'Master\CabangController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/cabang'], function () {
                        Route::get('{id}/edit', 'Master\CabangController@edit');
                        Route::post('{id}/update', 'Master\CabangController@update');
                    });
                    Route::group(['middleware' => 'roled:master/cabang'], function () {
                        Route::get('{id}/destroy', 'Master\CabangController@destroy');
                    });
                });

                Route::group(['prefix' => 'cabangrekening'], function () {
                    Route::group(['middleware' => 'role:master/cabangrekening'], function () {
                        Route::get('', 'Master\CabangrekeningController@index');
                        Route::get('search', 'Master\CabangrekeningController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/cabangrekening'], function () {
                        Route::get('create', 'Master\CabangrekeningController@create');
                        Route::post('', 'Master\CabangrekeningController@store');
                        Route::get('import', 'Master\CabangrekeningController@import');
                        Route::get('export', 'Master\CabangrekeningController@export');
                        Route::post('import', 'Master\CabangrekeningController@postimport');
                        Route::get('import/sample', 'Master\CabangrekeningController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/cabangrekening'], function () {
                        Route::get('{id}/edit', 'Master\CabangrekeningController@edit');
                        Route::post('{id}/update', 'Master\CabangrekeningController@update');
                    });
                    Route::group(['middleware' => 'roled:master/cabangrekening'], function () {
                        Route::get('{id}/destroy', 'Master\CabangrekeningController@destroy');
                    });
                });

                Route::group(['prefix' => 'katshuheader'], function () {
                    Route::group(['middleware' => 'role:master/katshuheader'], function () {
                        Route::get('', 'Master\KatshuheaderController@index');
                        Route::get('search', 'Master\KatshuheaderController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/katshuheader'], function () {
//                        Route::get('create', 'Master\KatshuheaderController@create');
                        Route::post('', 'Master\KatshuheaderController@store');
//                        Route::get('import', 'Master\KatshuheaderController@import');
                        Route::get('export', 'Master\KatshuheaderController@export');
//                        Route::post('import', 'Master\KatshuheaderController@postimport');
//                        Route::get('import/sample', 'Master\KatshuheaderController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/katshuheader'], function () {
                        Route::get('{id}/edit', 'Master\KatshuheaderController@edit');
                        Route::post('{id}/update', 'Master\KatshuheaderController@update');
                    });
                    Route::group(['middleware' => 'roled:master/katshuheader'], function () {
//                        Route::get('{id}/destroy', 'Master\KatshuheaderController@destroy');
                    });
                });

                Route::group(['prefix' => 'katshudetail'], function () {
                    Route::group(['middleware' => 'role:master/katshudetail'], function () {
                        Route::get('', 'Master\KatshudetailController@index');
                        Route::get('search', 'Master\KatshudetailController@search');
                    });
                    Route::group(['middleware' => 'rolec:master/katshudetail'], function () {
                        Route::get('create', 'Master\KatshudetailController@create');
                        Route::post('', 'Master\KatshudetailController@store');
                        Route::get('import', 'Master\KatshudetailController@import');
                        Route::get('export', 'Master\KatshudetailController@export');
                        Route::post('import', 'Master\KatshudetailController@postimport');
                        Route::get('import/sample', 'Master\KatshudetailController@sampleimport');
                    });
                    Route::group(['middleware' => 'roleu:master/katshudetail'], function () {
                        Route::get('{id}/edit', 'Master\KatshudetailController@edit');
                        Route::post('{id}/update', 'Master\KatshudetailController@update');
                    });
                    Route::group(['middleware' => 'roled:master/katshudetail'], function () {
                        Route::get('{id}/destroy', 'Master\KatshudetailController@destroy');
                    });
                });

            });

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            Route::group(['prefix' => 'simpanan'], function () {
                Route::group(['middleware' => 'role:simpanan'], function () {
                    Route::get('', 'Simpanan\SimpananController@index');
                    Route::get('search', 'Simpanan\SimpananController@search');
                });
                Route::group(['middleware' => 'rolec:simpanan'], function () {
                    Route::get('create', 'Simpanan\SimpananController@create');
                    Route::post('', 'Simpanan\SimpananController@store');
                    Route::get('import', 'Simpanan\SimpananController@import');
                    Route::post('import', 'Simpanan\SimpananController@postimport');
                    Route::get('import/sample', 'Simpanan\SimpananController@sampleimport');
                });
                Route::group(['middleware' => 'roleu:simpanan'], function () {
                    Route::get('tutup/{id}/{status}', 'Simpanan\SimpananController@tutupsimpanan');
                    Route::get('{id}/edit', 'Simpanan\SimpananController@edit');
                    Route::post('{id}/update', 'Simpanan\SimpananController@update');
                });
                Route::group(['middleware' => 'roled:simpanan'], function () {
                    Route::get('{id}/destroy', 'Simpanan\SimpananController@destroy');
                });
                Route::get('ajax/anggota/{id}', 'Simpanan\SimpananController@ajaxanggota');
                Route::get('ajax/cekstatus/{id}', 'Simpanan\SimpananController@ajaxcekstatus');
                Route::get('cek/{ida}/{idp}/{setorb}/{saldob}', 'Simpanan\SimpananController@cekaturan');


                Route::group(['prefix' => 'pengaturan'], function () {

                    Route::group(['middleware' => 'role:simpanan/pengaturan'], function () {
                        Route::get('', 'Simpanan\PengaturanController@index');
                        Route::get('search', 'Simpanan\PengaturanController@search');
                    });
                    Route::group(['middleware' => 'rolec:simpanan/pengaturan'], function () {
                        Route::get('create', 'Simpanan\PengaturanController@create');
                        Route::post('', 'Simpanan\PengaturanController@store');
                    });
                    Route::group(['middleware' => 'roleu:simpanan/pengaturan'], function () {
                        Route::get('{id}/edit', 'Simpanan\PengaturanController@edit');
                        Route::post('{id}/update', 'Simpanan\PengaturanController@update');
                    });
                    Route::group(['middleware' => 'roled:simpanan/pengaturan'], function () {
                        Route::get('{id}/destroy', 'Simpanan\PengaturanController@destroy');
                    });
                    Route::get('generate/{id}', 'Simpanan\PengaturanController@generate');
                    Route::get('sukubunga/{id}', 'Simpanan\PengaturanController@sukubunga');
                    Route::get('sistembunga/{id}', 'Simpanan\PengaturanController@sistembunga');
                    Route::get('approve/delete/{id}', 'Simpanan\PengaturanController@destroyapprove');
                    Route::get('akses/delete/{id}', 'Simpanan\PengaturanController@destroyakses');
                });

                Route::group(['prefix' => 'transaksi'], function () {
                    Route::group(['middleware' => 'role:simpanan/transaksi'], function () {
                        Route::get('', 'Simpanan\TransaksiController@index');
                        Route::get('search', 'Simpanan\TransaksiController@search');
                        Route::get('{id}/show', 'Simpanan\TransaksiController@show');
                    });
                    Route::group(['middleware' => 'rolec:simpanan/transaksi'], function () {
                        Route::get('create', 'Simpanan\TransaksiController@create');
                        Route::post('', 'Simpanan\TransaksiController@store');
                        Route::get('ajax/{id}', 'Simpanan\TransaksiController@transaksiajax');
                        Route::get('cek/{idp}/{saldo}/{nominal}/{status}', 'Simpanan\TransaksiController@cekaturan');
                    });
                    Route::group(['middleware' => 'roled:simpanan/transaksi'], function () {
                        Route::get('{id}/destroy', 'Simpanan\TransaksiController@destroy');
                    });
                });

                Route::group(['middleware' => 'role:simpanan/kolektif'], function () {
                    Route::resource('kolektif', 'Simpanan\KolektifController', ['only' => ['index', 'store']]);
                    Route::get('kolektif/up', 'Simpanan\KolektifController@up');
                    Route::get('kolektif/down', 'Simpanan\KolektifController@down');
                    Route::get('kolektif/cekup', 'Simpanan\KolektifController@cekup');
                    Route::get('kolektif/cekaturan/{ids}/{jumlah}/{tipe}', 'Simpanan\KolektifController@cekaturan');
                });

                Route::group(['middleware' => 'role:simpanan/mutasi'], function () {
                    Route::resource('mutasi', 'Simpanan\MutasiController', ['only' => ['index']]);
                    Route::get('mutasi/search/{id}/{df}/{dt}', 'Simpanan\MutasiController@show');
                    Route::get('mutasi/search2/{id}/{df}/{dt}', 'Simpanan\MutasiController@show2');
                    Route::get('mutasi/cetak/{id}/{df}/{dt}/{ctk}', 'Simpanan\MutasiController@cetak');
                });

                Route::group(['middleware' => 'role:simpanan/proses'], function () {
                    Route::get('proses/cek', 'Simpanan\MutasiController@cekproses');
                    Route::get('proses', 'Simpanan\MutasiController@proses');
                    Route::get('proses/show/{bln}/{th}', 'Simpanan\MutasiController@proseslihat');
                    Route::get('proses/cetak/{bln}/{th}', 'Simpanan\MutasiController@prosescetak');
                });
                Route::group(['middleware' => 'rolec:simpanan/proses'], function () {
                    Route::post('proses', 'Simpanan\MutasiController@postproses');
                });


            });

            //////////////////////////////////////////////////////////////////////////////////////////////

            Route::group(['prefix' => 'pinjaman'], function () {

                Route::get('wwk/{id}/{wk}', 'Pinjaman\PengaturanController@wwk');
                Route::group(['middleware' => 'role:pinjaman'], function () {
                    Route::get('', 'Pinjaman\PinjamanController@index');
                    Route::get('search', 'Pinjaman\PinjamanController@search');
                    Route::get('search/{pilih}/{radio}', 'Pinjaman\PinjamanController@search2');
                    Route::get('search2/{pilih}/{radio}', 'Pinjaman\PinjamanController@search3');
                });
                Route::group(['middleware' => 'rolec:pinjaman'], function () {
                    Route::get('create', 'Pinjaman\PinjamanController@create');
                    Route::get('{id}/edit/jaminan', 'Pinjaman\PinjamanController@edit2');
                    Route::post('', 'Pinjaman\PinjamanController@store');
                    Route::get('import', 'Pinjaman\PinjamanController@import');
                    Route::post('import', 'Pinjaman\PinjamanController@postimport');
                    Route::get('import/sample', 'Pinjaman\PinjamanController@sampleimport');
                    Route::get('jaminan/ajax/{aksi}', 'Pinjaman\PinjamanController@jaminanajax');
                    Route::post('jaminan/post', 'Pinjaman\PinjamanController@jaminanpost');
                    Route::get('jaminan/delete/{id}/{aksi}', 'Pinjaman\PinjamanController@jaminandelete');
                    Route::get('jaminan/edit/{id}', 'Pinjaman\PinjamanController@jaminanedit');
                    Route::get('jaminan/jenis/{id}', 'Pinjaman\PinjamanController@jaminanedit2');
                    Route::get('jaminan/ikatan/{id}', 'Pinjaman\PinjamanController@jaminanedit3');
                    Route::get('cek/tempo/{tgl}/{sel}', 'Pinjaman\PinjamanController@cektempo');
                });
                Route::group(['middleware' => 'roleu:pinjaman'], function () {
                    Route::get('{id}/edit', 'Pinjaman\PinjamanController@edit');
                    Route::get('{id}/edit2', 'Pinjaman\PinjamanController@edit2');
                    Route::post('{id}/update', 'Pinjaman\PinjamanController@update');
                    Route::get('jaminan/ajax/{aksi}', 'Pinjaman\PinjamanController@jaminanajax');
                    Route::post('jaminan/post', 'Pinjaman\PinjamanController@jaminanpost');
                    Route::get('jaminan/delete/{id}/{aksi}', 'Pinjaman\PinjamanController@jaminandelete');
                    Route::get('jaminan/edit/{id}', 'Pinjaman\PinjamanController@jaminanedit');
                    Route::get('jaminan/jenis/{id}', 'Pinjaman\PinjamanController@jaminanedit2');
                    Route::get('jaminan/ikatan/{id}', 'Pinjaman\PinjamanController@jaminanedit3');
                    Route::get('cek/tempo/{tgl}/{sel}/{idp}', 'Pinjaman\PinjamanController@cektempo');
                    Route::get('tutup/{id}', 'Pinjaman\PinjamanController@tutuppinjaman');
                    Route::get('reject/{id}', 'Pinjaman\PinjamanController@rejectpinjaman');
                });
                Route::group(['middleware' => 'roled:pinjaman'], function () {
                    Route::get('{id}/destroy', 'Pinjaman\PinjamanController@destroy');
                });
                Route::get('ajax', 'Pinjaman\PinjamanController@ajaxpinjaman');
                Route::get('cekreal/{idp}', 'Pinjaman\PinjamanController@cekreal');
                Route::get('cek/{ida}', 'Pinjaman\PinjamanController@cekpinjam');

                Route::group(['middleware' => 'role:pinjaman/mutasi'], function () {
                    Route::get('mutasi', 'Pinjaman\MutasiController@index');
                    Route::get('mutasi/ajax/{idp}', 'Pinjaman\MutasiController@ajax');
                    Route::get('mutasi/ajax/table/{idp}', 'Pinjaman\MutasiController@ajaxtable');
                    Route::get('mutasi/cetak/{idp}/{ctk}', 'Pinjaman\MutasiController@cetak');
                });

                Route::group(['prefix' => 'reschedule'], function () {
                    Route::group(['middleware' => 'role:pinjaman/reschedule'], function () {
                        Route::get('', 'Pinjaman\RescheduleController@index');
                        Route::get('search', 'Pinjaman\RescheduleController@search');
                    });
                    Route::group(['middleware' => 'rolec:pinjaman/reschedule'], function () {
                        Route::post('add', 'Pinjaman\RescheduleController@addpinjaman');
                        Route::get('create', 'Pinjaman\RescheduleController@create');
                        Route::post('store', 'Pinjaman\RescheduleController@store');
                    });
                });

                Route::group(['prefix' => 'pengaturan'], function () {
                    Route::group(['middleware' => 'role:pinjaman/pengaturan'], function () {
                        Route::get('', 'Pinjaman\PengaturanController@index');
                        Route::get('search', 'Pinjaman\PengaturanController@search');
                    });
                    Route::group(['middleware' => 'rolec:pinjaman/pengaturan'], function () {
                        Route::get('create', 'Pinjaman\PengaturanController@create');
                        Route::post('', 'Pinjaman\PengaturanController@store');
                    });
                    Route::group(['middleware' => 'roleu:pinjaman/pengaturan'], function () {
                        Route::get('{id}/edit', 'Pinjaman\PengaturanController@edit');
                        Route::post('{id}/update', 'Pinjaman\PengaturanController@update');
                    });
                    Route::group(['middleware' => 'roled:pinjaman/pengaturan'], function () {
                        Route::get('{id}/destroy', 'Pinjaman\PengaturanController@destroy');
                    });
                    Route::get('generate/{id}', 'Pinjaman\PengaturanController@generate');
                    Route::get('sukubunga/{id}', 'Pinjaman\PengaturanController@sukubunga');
                    Route::get('sistembunga/{id}', 'Pinjaman\PengaturanController@sistembunga');
                    Route::get('jkredit/{id}', 'Pinjaman\PengaturanController@jkredit');
                    Route::get('jkredit2/{id}', 'Pinjaman\PengaturanController@jkredit2');
                    Route::get('attach/doc/{idp}', 'Attach\AttachController@ajaxdoc');
                    Route::post('attach', 'Attach\AttachController@store');
                    Route::get('attach/destroy/{id}/{idp}', 'Attach\AttachController@destroy');
                    Route::get('attach/download/{id}', 'Attach\AttachController@download');
                    Route::get('attach/preview/{id}', 'Attach\AttachController@show');
                    Route::get('approve/delete/{id}', 'Pinjaman\PengaturanController@destroyapprove');
                    Route::get('akses/delete/{id}', 'Pinjaman\PengaturanController@destroyakses');
                });

                Route::group(['middleware' => 'rolec:pinjaman/realisasi'], function () {
                    Route::resource('realisasi', 'Pinjaman\RealisasiController', ['only' => ['index', 'store']]);
                    Route::get('realisasi/ajax/{id}', 'Pinjaman\RealisasiController@realisasiajax');
                    Route::get('realisasi/{id}', 'Pinjaman\RealisasiController@show');
                    Route::get('real/ajax', 'Pinjaman\RealisasiController@realajax');
                    Route::get('biaya/ajax', 'Pinjaman\RealisasiController@biayaajax');
                    Route::get('realisasi/tjamin/{idp}', 'Pinjaman\RealisasiController@tablejamin');
                    Route::get('realisasi/tket/{idj}', 'Pinjaman\RealisasiController@tableket');
                    Route::get('realisasi/cek', 'Pinjaman\RealisasiController@cekmodul');
                });

                Route::group(['middleware' => 'role:pinjaman/pembayaran'], function () {
                    Route::get('pembayaran', 'Pinjaman\PembayaranController@index');
                    Route::get('pembayaran/search', 'Pinjaman\PembayaranController@search');
                    Route::get('pembayaran/{id}/show', 'Pinjaman\PembayaranController@show');
                });
                Route::group(['middleware' => 'rolec:pinjaman/pembayaran'], function () {
                    Route::get('pembayaran/create', 'Pinjaman\PembayaranController@create');
                    Route::post('pembayaran', 'Pinjaman\PembayaranController@store');
                    Route::get('simulasi', 'Pinjaman\RealisasiController@simulasi');
                    Route::get('listbayar/{idp}', 'Pinjaman\PembayaranController@listbayar');
                    Route::get('bayar/ajax/{idp}', 'Pinjaman\PembayaranController@bayarajax');
                    Route::get('bayar/total', 'Pinjaman\PembayaranController@bayartotal');
                    Route::get('bayar/cek', 'Pinjaman\PembayaranController@cekaturan');
                    Route::get('bayar/loadsaldo/{ids}', 'Pinjaman\PembayaranController@loadsaldo');
                    Route::get('bayar/ceksaldo/{total}/{saldo}', 'Pinjaman\PembayaranController@ceksaldo');
                    Route::get('bayar/cekauto/{auto}', 'Pinjaman\PembayaranController@cekauto');
                });
                Route::group(['middleware' => 'roled:pinjaman/pembayaran'], function () {
                    Route::get('pembayaran/{id}/destroy', 'Pinjaman\PembayaranController@destroy');
                });

                Route::get('api/sistembunga/{idsukubunga}/{jangkawaktu}', 'Pinjaman\RealisasiController@getSimulasi');

                Route::get('sistembunga/{idsistembunga}/{idpinjaman}/{real}', 'Pinjaman\RealisasiController@testSimulasi');
                Route::get('sistembunga2/{idsistembunga}/{idpinjaman}', 'Pinjaman\PembayaranController@testSimulasi');
                Route::get('sistemsimulasi/{idsistembunga}/{idpengaturan}', 'Pinjaman\PinjamanController@testSimulasi');




            });


            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            Route::group(['prefix' => 'laporan'], function () {

                Route::group(['prefix' => 'perkiraan'], function () {
                    Route::get('', 'Laporan\PerkiraanController@index');
                    Route::get('cetak', 'Laporan\PerkiraanController@cetak');
                });

                Route::group(['prefix' => 'kas'], function () {
                    Route::get('', 'Laporan\KaslapController@kasawal');
                    Route::get('cetak', 'Laporan\KaslapController@kascetak');
                });

                Route::group(['prefix' => 'jurnal'], function () {
                    Route::get('', 'Laporan\JurnalController@index');
                    Route::get('cetak', 'Laporan\JurnalController@cetak');
                });

                Route::group(['prefix' => 'labarugi'], function () {
                    Route::get('', 'Laporan\LabaRugiController@index');
                    Route::get('cetak', 'Laporan\LabaRugiController@cetak');
                });

                Route::group(['prefix' => 'labarugiytd'], function () {
                    Route::get('', 'Laporan\LabaRugiYTDController@index');
                    Route::get('cetak', 'Laporan\LabaRugiYTDController@cetak');
                });

                Route::group(['prefix' => 'neraca'], function () {
                    Route::get('', 'Laporan\NeracaController@index');
                    Route::get('cetak', 'Laporan\NeracaController@cetak');
                });

                Route::group(['prefix' => 'neracalajur'], function () {
                    Route::get('', 'Laporan\NeracaLajurController@index');
                    Route::get('cetak', 'Laporan\NeracaLajurController@cetak');
                });

                Route::group(['prefix' => 'neracasaldo'], function () {
                    Route::get('', 'Laporan\NeracaSaldoController@index');
                    Route::get('cetak', 'Laporan\NeracaSaldoController@cetak');
                });


                Route::group(['prefix' => 'keuangan'], function () {
                    Route::group(['middleware' => 'role:laporan/keuangan/laba/bulanan'], function () {
                        Route::get('laba/bulanan', 'Laporan\KeuanganController@lababln');
                    });
                    Route::group(['middleware' => 'role:laporan/keuangan/laba/ytd'], function () {
                        Route::get('laba/ytd', 'Laporan\KeuanganController@labaytd');
                    });
                    Route::group(['middleware' => 'role:laporan/keuangan/neraca'], function () {
                        Route::get('neraca', 'Laporan\NeracaController@neraca');
                        Route::get('neraca/cetak', 'Laporan\NeracaController@neraca_cetak');
                    });
                    Route::group(['middleware' => 'role:laporan/keuangan/neraca/lajur'], function () {
                        Route::get('neraca/lajur', 'Laporan\KeuanganController@neracaljr');
                    });
                    Route::group(['middleware' => 'role:laporan/keuangan/neraca/saldo'], function () {
                        Route::get('neraca/saldo', 'Laporan\KeuanganController@neracasaldo');
                    });
                });

                Route::group(['prefix' => 'kas'], function () {
                    Route::group(['middleware' => 'role:laporan/kas/transaksi/masuk'], function () {
                        Route::get('transaksi/masuk', 'Laporan\KaslapController@trankas');
                        Route::post('transaksi/masuk/cetak', 'Laporan\KaslapController@trankas_cetak');
                    });
                    Route::group(['middleware' => 'role:laporan/kas/transaksi/keluar'], function () {
                        Route::get('transaksi/keluar', 'Laporan\KaslapController@trankas_keluar');
                        Route::post('transaksi/keluar/cetak', 'Laporan\KaslapController@trankaskeluar_cetak');
                    });
                    Route::group(['middleware' => 'role:laporan/kas/transaksi/transfer'], function () {
                        Route::get('transaksi/transfer', 'Laporan\KaslapController@trankas_transfer');
                        Route::post('transaksi/transfer/cetak', 'Laporan\KaslapController@trankastransfer_cetak');
                    });

                });

                Route::group(['prefix' => 'lain'], function () {
                    Route::group(['middleware' => 'role:laporan/lain/daftae/akun'], function () {
                        Route::get('daftar/akun', 'Laporan\LainController@dtrakun');
                        Route::post('daftar/akun/cetak', 'Laporan\LainController@dtakun_cetak');
                    });
                    Route::group(['middleware' => 'role:laporan/lain/daftar/jurnal'], function () {
                        Route::get('daftar/jurnal', 'Laporan\LainController@dtrjrl');
                        Route::post('daftar/jurnal/cetak', 'Laporan\LainController@dtjurnal_cetak');
                    });

                    Route::get('transaksi/pos', 'Laporan\LainController@pos');
                    Route::post('transaksi/pos/cetak', 'Laporan\LainController@pos_cetak');

                    Route::get('tabungan', 'Laporan\LainController@tabungan');
                    Route::post('tabungan/cetak', 'Laporan\LainController@tabungan_cetak');

                    Route::get('tabungantrans', 'Laporan\LainController@tabungantrans');
                    Route::post('tabungantrans/cetak', 'Laporan\LainController@tabungantrans_cetak');

                    Route::get('neracasaldo', 'Laporan\LainController@neracasaldo');
                    Route::post('neracasaldo/cetak', 'Laporan\LainController@neracasaldo_cetak');

                });

                Route::group(['prefix' => 'pinjaman'], function () {

                    Route::group(['middleware' => 'role:laporan/pinjaman/data'], function () {
                        Route::get('data', 'Laporan\PinjamanController@dtpin');
                        Route::get('data/cetak', 'Laporan\PinjamanController@cetakdtpin');
                    });
                    Route::group(['middleware' => 'role:laporan/pinjaman/kolektibilitas'], function () {
                        Route::get('kolektibilitas', 'Laporan\PinjamanController@kopin');
                        Route::get('kolektibilitas/cetak', 'Laporan\PinjamanController@cetakkopin');
                    });
                    Route::group(['middleware' => 'role:laporan/pinjaman/realisasi'], function () {
                        Route::get('realisasi', 'Laporan\PinjamanController@realpin');
                        Route::get('realisasi/cetak', 'Laporan\PinjamanController@cetakrealpin');
                    });
                    Route::group(['middleware' => 'role:laporan/pinjaman/saldo'], function () {
                        Route::get('saldo', 'Laporan\PinjamanController@saldopin');
                        Route::get('saldo/cetak', 'Laporan\PinjamanController@cetaksaldopin');
                    });
                    Route::group(['middleware' => 'role:laporan/pinjaman/transaksi'], function () {
                        Route::get('transaksi', 'Laporan\PinjamanController@tranpin');
                        Route::get('transaksi/cetak', 'Laporan\PinjamanController@cetaktranpin');
                    });
                });

                Route::group(['prefix' => 'simpanan'], function () {

                    Route::group(['middleware' => 'role:laporan/simpanan/data'], function () {
                        Route::get('data', 'Laporan\SimpananController@dtsimp');
                        Route::get('data/cetak', 'Laporan\SimpananController@cetakdtsimp');
                    });
                    Route::group(['middleware' => 'role:laporan/simpanan/saldo'], function () {
                        Route::get('saldo', 'Laporan\SimpananController@saldosimp');
                        Route::get('saldo/cetak', 'Laporan\SimpananController@cetaksaldosimp');
                    });
                    Route::group(['middleware' => 'role:laporan/simpanan/saldo/jenis'], function () {
                        Route::get('saldo/jenis', 'Laporan\SimpananController@saldosimpjns');
                        Route::get('saldo/jenis/cetak', 'Laporan\SimpananController@cetaksaldosimpjns');
                    });
                    Route::group(['middleware' => 'role:laporan/simpanan/transaksi'], function () {
                        Route::get('transaksi', 'Laporan\SimpananController@transimp');
                        Route::get('transaksi/cetak', 'Laporan\SimpananController@cetaktransimp');
                    });
                });

                Route::group(['prefix' => 'waserda'], function () {

//                    Route::group(['middleware' => 'role:laporan/waserda/stok'], function () {
                    Route::get('stok', 'Laporan\WaserdaController@dtstok');
                    Route::get('stok/cetak', 'Laporan\WaserdaController@cetakdtstok');
//                    });
//                    Route::group(['middleware' => 'role:laporan/waserda/penjualan'], function () {
                    Route::get('penjualan', 'Laporan\WaserdaController@jual');
                    Route::get('penjualan/cetak', 'Laporan\WaserdaController@cetakjual');
//                    });
//                    Route::group(['middleware' => 'role:laporan/waserda/penjualan/anggota'], function () {
                    Route::get('penjualan/anggota', 'Laporan\WaserdaController@jualcs');
                    Route::get('penjualan/anggota/cetak', 'Laporan\WaserdaController@cetakjualcs');
//                    });
//                    Route::group(['middleware' => 'role:laporan/waserda/penjualan/hpp'], function () {
                    Route::get('penjualan/hpp', 'Laporan\WaserdaController@jualhpp');
                    Route::get('penjualan/hpp/cetak', 'Laporan\WaserdaController@cetakjualhpp');
//                    });
                });

                Route::group(['middleware' => 'role:laporan/customer/data'], function () {
                    Route::get('customer/data', 'Laporan\MasterController@dtanggota');
                    Route::get('customer/data/cetak', 'Laporan\MasterController@cetak');
                });

            });

            //////////////////////////////////////////////////////////////////////////////////////////////

            //////////////////////////////akuntansi///////////////////////////

            Route::group(['prefix' => 'akuntansi'], function () {

                Route::group(['prefix' => 'penyusutan'], function () {
                    Route::group(['middleware' => 'role:akuntansi/penyusutan'], function () {
                        Route::get('', 'Akuntansi\PenyusutanController@index');
                        Route::get('search', 'Akuntansi\PenyusutanController@search');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/penyusutan'], function () {
                        Route::get('create/aset', 'Akuntansi\PenyusutanController@create');
                        Route::post('', 'Akuntansi\PenyusutanController@store');
                    });
                    Route::group(['middleware' => 'roleu:akuntansi/penyusutan'], function () {
                        Route::get('edit/{id}/aset', 'Akuntansi\PenyusutanController@edit');
                        Route::post('update/{id}/aset', 'Akuntansi\PenyusutanController@update');
                    });
                    Route::group(['middleware' => 'roled:akuntansi/penyusutan'], function () {
                        Route::get('destroy/{id}/aset', 'Akuntansi\PenyusutanController@destroy');
                    });

                    Route::get('detail/{id}/aset', 'Akuntansi\PenyusutanController@show');
                    Route::get('detail/table/{id}/aset', 'Akuntansi\PenyusutanController@showtable');
                    Route::get('proses/{id}/aset', 'Akuntansi\PenyusutanController@proses');

                    Route::get('ajax/{bln}/{harga}', 'Akuntansi\PenyusutanController@ajax');
                    Route::get('cekjurnal', 'Akuntansi\PenyusutanController@cekjurnal');
                });

                Route::group(['prefix' => 'proyeksi'], function () {
                    Route::group(['prefix' => 'simpanan'], function () {
                        Route::group(['middleware' => 'role:akuntansi/proyeksi/simpanan'], function () {
                            Route::get('', 'Akuntansi\ProyeksiController@indexsimpanan');
                            Route::get('cetak', 'Akuntansi\ProyeksiController@cetaksimpanan');
                            Route::get('excel', 'Akuntansi\ProyeksiController@excelsimpanan');
                        });

                        Route::group(['middleware' => 'role:akuntansi/proyeksi/simpanan/bunga'], function () {
                            Route::get('bunga', 'Akuntansi\ProyeksiController@indexbungasimpanan');
                            Route::get('bunga/cetak', 'Akuntansi\ProyeksiController@cetakbungasimpanan');
                            Route::get('bunga/excel', 'Akuntansi\ProyeksiController@excelbungasimpanan');
                        });
                    });

                    Route::group(['prefix' => 'pinjaman'], function () {
                        Route::group(['middleware' => 'role:akuntansi/proyeksi/pinjaman'], function () {
                            Route::get('', 'Akuntansi\ProyeksiController@indexpinjaman');
                            Route::get('cetak', 'Akuntansi\ProyeksiController@cetakpinjaman');
                            Route::get('excel', 'Akuntansi\ProyeksiController@excelpinjaman');
                        });
                    });
                });

                Route::group(['prefix' => 'autodebet'], function () {
                    Route::get('cekshu/{shu}', 'Pinjaman\AutoController@cekshu');
                    Route::group(['prefix' => 'simpanan'], function () {
                        Route::group(['middleware' => 'role:akuntansi/autodebet/simpanan'], function () {
                            Route::get('', 'Simpanan\MutasiController@autodebet');
                            Route::get('cek', 'Simpanan\MutasiController@cekautodebet');
                            Route::get('show/{bln}/{th}/{shu}', 'Simpanan\MutasiController@autodebetlihat');
                            Route::get('cetak/{bln}/{th}/{shu}', 'Simpanan\MutasiController@autodebetcetak');
                            Route::get('download/{link}', 'Simpanan\MutasiController@download');
                        });
                        Route::group(['middleware' => 'rolec:akuntansi/autodebet/simpanan'], function () {
                            Route::get('download/{bln}/{th}/{shu}/{df}/{dt}', 'Simpanan\MutasiController@autodebetdownload');
                            Route::post('', 'Simpanan\MutasiController@autodebetupload');
                        });
                    });

                    Route::group(['prefix' => 'pinjaman'], function () {
                        Route::group(['middleware' => 'role:akuntansi/autodebet/pinjaman'], function () {
                            Route::get('', 'Pinjaman\AutoController@autodebet');
                            Route::get('cek', 'Pinjaman\AutoController@cekautodebet');
                            Route::get('show/{bln}/{th}/{shu}', 'Pinjaman\AutoController@autodebetlihat');
                            Route::get('cetak/{bln}/{th}/{shu}', 'Pinjaman\AutoController@autodebetcetak');
                            Route::get('download/{link}', 'Pinjaman\AutoController@download');
                        });
                        Route::group(['middleware' => 'rolec:akuntansi/autodebet/pinjaman'], function () {
                            Route::get('download/{bln}/{th}/{shu}/{df}/{dt}', 'Pinjaman\AutoController@autodebetdownload');
                            Route::post('', 'Pinjaman\AutoController@autodebetupload');
                        });
                    });

                    Route::group(['prefix' => 'waserda'], function () {
//                        Route::group(['middleware' => 'role:akuntansi/autodebet/waserda'], function () {
                        Route::get('', 'Akuntansi\AutowaserdaController@autodebet');
                        Route::get('cek', 'Akuntansi\AutowaserdaController@cekautodebet');
                        Route::get('show/{bln}/{th}', 'Akuntansi\AutowaserdaController@autodebetlihat');
                        Route::get('cetak/{bln}/{th}', 'Akuntansi\AutowaserdaController@autodebetcetak');
                        Route::get('download/{link}', 'Akuntansi\AutowaserdaController@download');
//                        });
//                        Route::group(['middleware' => 'rolec:akuntansi/autodebet/waserda'], function () {
                        Route::get('download/{bln}/{th}/{shu}/{df}/{dt}', 'Akuntansi\AutowaserdaController@autodebetdownload');
                        Route::post('', 'Akuntansi\AutowaserdaController@autodebetupload');
//                        });
                    });
                });

                Route::group(['prefix' => 'perkiraan'], function () {
                    Route::group(['middleware' => 'role:akuntansi/perkiraan'], function () {
                        Route::get('', 'Akuntansi\perkiraan\PerkiraanController@index');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/perkiraan'], function () {
                        Route::get('create/{id}', 'Akuntansi\perkiraan\PerkiraanController@create');
                        Route::get('create', 'Akuntansi\perkiraan\PerkiraanController@create2');
                        Route::get('parentget/{id}', 'Akuntansi\perkiraan\PerkiraanController@index2');
                        Route::get('kelompokget/{id}', 'Akuntansi\perkiraan\PerkiraanController@kelompokget');
                        Route::get('headersget/{id}', 'Akuntansi\perkiraan\PerkiraanController@headersget');
                        Route::post('store', 'Akuntansi\perkiraan\PerkiraanController@store');
                        Route::post('headerstore', 'Akuntansi\perkiraan\PerkiraanController@headerstore');
                        Route::get('import', 'Akuntansi\perkiraan\PerkiraanController@import');
                        Route::post('import/post', 'Akuntansi\perkiraan\PerkiraanController@importpost');
                        Route::get('import/sample', 'Akuntansi\perkiraan\PerkiraanController@sample');
                    });
                    Route::group(['middleware' => 'roleu:akuntansi/perkiraan'], function () {
                        Route::get('edit/{id}', 'Akuntansi\perkiraan\PerkiraanController@edit');
                        Route::post('update/{id}', 'Akuntansi\perkiraan\PerkiraanController@update');
                    });
                    Route::group(['middleware' => 'roled:akuntansi/perkiraan'], function () {
                        Route::get('hapus/{id}', 'Akuntansi\perkiraan\PerkiraanController@destroy');
                    });

                });


                Route::group(['prefix' => 'jurnal'], function () {
                    Route::group(['middleware' => 'role:akuntansi/jurnal/semua'], function () {
                        Route::get('', 'Akuntansi\jurnal\JurnalController@indexmanual');
                        Route::get('simpanan', 'Akuntansi\jurnal\JurnalController@indexsimpanan');
                        Route::get('pinjaman', 'Akuntansi\jurnal\JurnalController@indexpinjaman');
                        Route::get('kas', 'Akuntansi\jurnal\JurnalController@indexkas');
                        Route::get('waserda', 'Akuntansi\jurnal\JurnalController@indexwaserda');
                        Route::get('semua', 'Akuntansi\jurnal\JurnalController@indexsemua');
                        Route::get('search', 'Akuntansi\jurnal\JurnalController@searchmanual');
                        Route::get('search/simpanan', 'Akuntansi\jurnal\JurnalController@searchsimpanan');
                        Route::get('search/pinjaman', 'Akuntansi\jurnal\JurnalController@searchpinjaman');
                        Route::get('search/kas', 'Akuntansi\jurnal\JurnalController@searchkas');
                        Route::get('search/waserda', 'Akuntansi\jurnal\JurnalController@searchwaserda');
                        Route::get('search/semua', 'Akuntansi\jurnal\JurnalController@searchsemua');
                        Route::get('cetak/{tipe}/{status}', 'Akuntansi\jurnal\JurnalController@cetak');
                    });
                    Route::group(['middleware' => 'roleu:akuntansi/jurnal/semua'], function () {
                        Route::post('posting', 'Akuntansi\jurnal\JurnalController@posting');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/jurnal/semua'], function () {
                        Route::get('ceknomor', 'Akuntansi\jurnal\JurnalController@ceknomor');
                        Route::get('create', 'Akuntansi\jurnal\JurnalController@create');
                        Route::post('store', 'Akuntansi\jurnal\JurnalController@store');
                    });
                });

                Route::group(['prefix' => 'bukubesar'], function () {
                    Route::group(['middleware' => 'role:akuntansi/bukubesar'], function () {
                        Route::resource('', 'Akuntansi\bukubesar\BukubesarController@index');
                        Route::get('search', 'Akuntansi\bukubesar\BukubesarController@search');
                        Route::get('cetak', 'Akuntansi\bukubesar\BukubesarController@cetak');
                        Route::get('getnama/{id}', 'Akuntansi\bukubesar\BukubesarController@getnama');
                        Route::get('history/{id}', 'Akuntansi\bukubesar\BukubesarController@history');
                        Route::get('history2/{id}', 'Akuntansi\bukubesar\BukubesarController@history2');
                    });
                });

                Route::group(['prefix' => 'daftarkas'], function () {
                    Route::group(['middleware' => 'role:akuntansi/daftarkas'], function () {
                        Route::resource('', 'Akuntansi\daftarkas\DaftarkasController@index');
                        Route::get('search', 'Akuntansi\daftarkas\DaftarkasController@search');
                        Route::get('cetak', 'Akuntansi\daftarkas\DaftarkasController@cetak');
                    });
                });

                Route::group(['prefix' => 'kasmasuk'], function () {
                    Route::group(['middleware' => 'role:akuntansi/kasmasuk'], function () {
                        Route::get('', 'Akuntansi\daftarkas\KasMasukController@index');
                        Route::get('ceknomor', 'Akuntansi\da`ftarkas\KasMasukController@ceknomor');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/kasmasuk'], function () {
                        Route::post('store', 'Akuntansi\daftarkas\KasMasukController@store');
                    });
                });

                Route::group(['prefix' => 'kaskeluar'], function () {
                    Route::group(['middleware' => 'role:akuntansi/kaskeluar'], function () {
                        Route::get('', 'Akuntansi\daftarkas\KasKeluarController@index');
                        Route::get('ceknomor', 'Akuntansi\daftarkas\KasKeluarController@ceknomor');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/kaskeluar'], function () {
                        Route::post('store', 'Akuntansi\daftarkas\KasKeluarController@store');
                    });
                });

                Route::group(['prefix' => 'kastransfer', 'middleware' => 'role:akuntansi/kastransfer'], function () {
                    Route::group(['middleware' => 'role:akuntansi/kastransfer'], function () {
                        Route::get('', 'Akuntansi\daftarkas\KasTransferController@index');
                        Route::get('ceknomor', 'Akuntansi\daftarkas\KasTransferController@ceknomor');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/kastransfer'], function () {
                        Route::post('store', 'Akuntansi\daftarkas\KasTransferController@store');
                    });
                });

                Route::group(['prefix' => 'saldoawal'], function () {
                    Route::group(['middleware' => 'role:akuntansi/saldoawal'], function () {
                        Route::get('', 'Akuntansi\saldoawal\SaldoAwalController@index');
                        Route::get('ceknomor', 'Akuntansi\saldoawal\SaldoAwalController@ceknomor');
                        Route::get('getperkiraanpertama/{id}', 'Akuntansi\saldoawal\SaldoAwalController@getperkiraanpertama');
                        Route::get('getperkiraankedua/{id}', 'Akuntansi\saldoawal\SaldoAwalController@getperkiraankedua');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/saldoawal'], function () {
                        Route::post('store', 'Akuntansi\saldoawal\SaldoAwalController@store');
                    });
                });

                Route::group(['prefix' => 'pengaturanakun'], function () {
                    Route::group(['middleware' => 'role:akuntansi/pengaturanakun'], function () {
                        Route::get('', 'Akuntansi\pengaturan\PengaturanAkunController@index');
                    });
                    Route::group(['middleware' => 'roleu:akuntansi/pengaturanakun'], function () {
                        Route::post('update/{id}', 'Akuntansi\pengaturan\PengaturanAkunController@update');
                    });
                });

                Route::group(['prefix' => 'hitungshu'], function () {
                    Route::group(['middleware' => 'role:akuntansi/hitungshu'], function () {
                        Route::get('', 'Akuntansi\shu\ShuController@index');
                    });
                    Route::group(['middleware' => 'rolec:akuntansi/hitungshu'], function () {
                        Route::get('cek', 'Akuntansi\shu\ShuController@cek');
                        Route::get('bagishu/{id}', 'Akuntansi\shu\BagiShuController@show');
                        Route::post('store', 'Akuntansi\shu\ShuController@store');
                    });
                    Route::group(['middleware' => 'roled:akuntansi/hitungshu'], function () {
                        Route::get('hapus/{id}', 'Akuntansi\shu\ShuController@destroy');
                    });
                });

            });
        });








//////////////////////////////////POS////////////////////////////////////////////////



        Route::group(['middleware' => ['rpos'] ], function () {

            Route::get('/pos/penjualan/cek', 'Pos\TestController@cek');
            Route::get('/pos/index', 'Pos\PosController@index');

            Route::get('/pos/dataproduk/cek/{id}', 'Pos\TestController@cekproduk');
            Route::get('/pos/pwsupervisor', 'Pos\PosController@pwsupervisor');
            Route::get('/pos/transaksiautodebet/', 'Pos\PosController@transaksiautodebet');
            Route::get('/pos/printkau/{noref}/{saldoaw}/{sisasal}', 'Pos\PosController@printkartu');

            Route::get('/pos/supervisor/permission/', 'Pos\TestController@pwsupervisor');
            Route::get('/pos/supervisor/cek/{uname}/{pw}', 'Pos\TestController@ceksupervisor');


////PDF
            Route::get('/pos/kasir/harian/sum/pdf/{df}/{cabang}/{jenis}', 'Pos\PosController@pdftodayall');
            Route::get('/pos/kasir/harian/sumary/pdf/{idkasir}/{df}/{cabang}/{jenis}', 'Pos\PosController@pdftoday');

            Route::get('/pos/kasir/bulan/sum/pdf/{df}/{cabang}/{jenis}', 'Pos\PosController@pdfbulanall');
            Route::get('/pos/kasir/bln/sum/pdf/{idkasir}/{df}/{cabang}/{jenis}', 'Pos\PosController@pdfbulan');


            Route::get('/pos/kasir/thn/pdf/{idkasir}/{df}/{cabang}/{jenis}', 'Pos\PosController@pdftahun');
            Route::get('/pos/kasir/tahun/pdf/{df}/{cabang}/{jenis}', 'Pos\PosController@pdftahunall');
            //perioddik
            Route::get('/pos/kasir/periodik/allkasir/toall/pdf/{cabang}/{jenis}', 'Pos\PosController@alltoall');
            Route::get('/pos/kasir/periodik/all/to/pdf/{idkasir}/{cabang}/{jenis}', 'Pos\PosController@allto');

            Route::get('/pos/kasir/periodik/allkasir/today/pdf/{cabang}/{jenis}', 'Pos\PosController@todaytoall');
            Route::get('/pos/kasir/periodik/toto/pdf/{idkasir}/{cabang}/{jenis}', 'Pos\PosController@todayto');

            Route::get('/pos/laporan/periodik/allkasir/torange/pdf/hari/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@rangetoall');
            Route::get('/pos/laporan/periodik/allkasir/torange/pdf/bulan/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@rangetoallbln');
            Route::get('/pos/laporan/periodik/allkasir/torange/pdf/tahun/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@rangetoallthn');

            Route::get('/pos/laporan/periodik/sumrange/pdf/hari/{idkasir}/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@rangeto');
            Route::get('/pos/laporan/periodik/sumrange/pdf/bulan/{idkasir}/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@rangetobln');
            Route::get('/pos/laporan/periodik/sumrange/pdf/tahun/{idkasir}/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@rangetothn');

            Route::get('/pos/laporan/periodik/allkasir/anggota/pdf/hari/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@anggotatoall');
            Route::get('/pos/laporan/periodik/allkasir/anggota/pdf/bulan/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@anggotatoallbln');
            Route::get('/pos/laporan/periodik/allkasir/anggota/pdf/tahun/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@anggotatoallthn');

            Route::get('/pos/laporan/periodik/anggota/pdf/hari/{idkasir}/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@anggotato');
            Route::get('/pos/laporan/periodik/anggota/pdf/bulan/{idkasir}/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@anggotatobln');
            Route::get('/pos/laporan/periodik/anggota/pdf/tahun/{idkasir}/{df}/{dt}/{cabang}/{jenis}', 'Pos\PosController@anggotatothn');

            ////

            Route::get('/pos/autodebet/{total}/{ck1}/{ck2}/{ck3}/{norefnya}', 'Pos\PosController@autodebet');
            Route::get('/pos/berhasildebet/{sisasaldo}/{kartu}/{noref}', 'Pos\PosController@berhasildebet');



            Route::group(['middleware' => 'rolewas:pos/master'], function () {
                Route::get('/pos/master', 'Pos\MasterController@index');
            });

            Route::group(['middleware' => 'rolewas:pos/master/jenis'], function () {
                Route::get('/pos/master/jenis', 'Pos\MasterController@jenis');
            });
            Route::group(['middleware' => 'rolewasu:pos/master/jenis'], function () {
                Route::get('/pos/master/jenis/simpan/{id1}/{id2}', 'Pos\MasterController@simpan');
            });
//            Route::post('/pos/master/instansi', 'Pos\MasterController@store');
            Route::get('/pos/saldo/saldonya', 'Pos\PosController@ceksaldo');
            Route::get('/pos/kasirtahunan', 'Pos\DetailController@kasirtahunan');


            Route::group(['middleware' => 'rolewas:pos/master/iklan'], function () {
                Route::get('/pos/master/iklan', 'Pos\MasterController@indexiklan');
            });
            Route::group(['middleware' => 'rolewasu:pos/master/iklan'], function () {
                Route::get('/pos/iklan/status/{angka}', 'Pos\IklanController@ohko');
            });

            Route::group(['middleware' => 'rolewas:pos/penjualan'], function () {
                Route::get('/pos/penjualan', 'Pos\TestController@index');
            });
            Route::group(['middleware' => 'rolewasc:pos/penjualan'], function () {
                Route::get('/pos/penjualan/{barcode}', 'Pos\TestController@store');
                Route::get('/pos/penjual/dataproduk', 'Pos\TestController@produk');
                Route::get('/pos/dataproduk/cari/{barang}', 'Pos\TestController@cariproduk');
            });
            Route::group(['middleware' => 'rolewasu:pos/penjualan'], function () {
                Route::get('/pos/edit/qty/tambah/{id}', 'Pos\BerhasilController@qtytambah');
                Route::get('/pos/edit/qty/kurang/{id}', 'Pos\BerhasilController@qtykurang');
                Route::get('/pos/ubah/qty/enter', 'Pos\BerhasilController@qtyenter');
                Route::get('/pos/penjualan/edit/{barcode}/{qtt}', 'Pos\TestController@edit');
            });
            Route::group(['middleware' => 'rolewasd:pos/penjualan'], function () {
                Route::get('/pos/void', 'Pos\TestController@void');
                Route::get('/pos/dete/{id}', 'Pos\TestController@destroy');
            });

            Route::group(['middleware' => 'rolewas:pos/tahan'], function () {
                Route::get('/pos/tahan', 'Pos\CashController@indexhold');
            });
            Route::group(['middleware' => 'rolewasc:pos/tahan'], function () {
                Route::get('/pos/penjual/hod/{norefnya}', 'Pos\CashController@hold');
                Route::get('/pos/penjualan/hod/{no}', 'Pos\CashController@destro');
            });
            Route::group(['middleware' => 'rolewasu:pos/tahan'], function () {
                Route::get('pos/holding/back/{noref}/{id}', 'Pos\HoldController@backholding');
            });

            Route::group(['middleware' => 'rolewac:pos/payment'], function () {
                Route::get('/pos/penjual/tunda/oooo/{nokartu}/{norefnya}', 'Pos\CashController@tunda');
                Route::get('/pos/penjual/tunda/{kartu}', 'Pos\CashController@cektunda');

                Route::get('/pos/getpayment/{norefnya}', 'Pos\MasterController@getpayment');
                Route::get('/pos/payment/{total}/{ck1}/{ck2}/{norefnya}', 'Pos\PosController@paymenttotal');

                Route::get('/pos/cas/{totalnya}/{eds}/{norefnya}', 'Pos\CashController@cash');
                Route::get('/pos/cash/{total}/{ck1}/{ck2}/{norefnya}', 'Pos\PosController@cashtotal');
                Route::get('/pos/tunda/{total}/{ck1}/{ck2}/{norefnya}', 'Pos\PosController@tunda');

                Route::get('/pos/printund/{kartu}/{total}/{noref}', 'Pos\PosController@printunda');
                Route::get('/pos/berhasiltunda/{kartu}/{total}/{noref}', 'Pos\PosController@berhasiltunda');
                Route::get('/pos/cek/berhasiltunda/{kartu}/{id}/{norefnya}', 'Pos\PosController@cekberhasiltunda');

                Route::get('/pos/printcash/{noref}/{bayaran}/{balian}', 'Pos\PosController@printcash');
                Route::get('/pos/berhasil/{pembayaran}/{kembali}/{noref}', 'Pos\PosController@totalkembali');
            });

            Route::group(['middleware' => 'rolewas:pos/retur'], function () {
                Route::get('/pos/retur/', 'Pos\HoldController@returnow');
            });
            Route::group(['middleware' => 'rolewasc:pos/retur'], function () {
                Route::get('/pos/returbarang/{nomor}/{jenis}', 'Pos\HoldController@retur');
                Route::get('/pos/cekretur', 'Pos\PosController@cekretur');
                Route::get('/pos/returbarang', 'Pos\PosController@returbarang');
            });

            Route::group(['middleware' => 'rolewas:pos/ceksaldo'], function () {
                Route::get('/pos/print/saldo/{kartus}', 'Pos\PosController@printsaldo');
                Route::get('/pos/saldo/saldonya/{saldonya}/{kartunya}/{total}', 'Pos\PosController@saldonya');
                Route::get('/pos/saldo', 'Pos\PosController@ceksaldo');
                Route::get('/pos/ceksaldo', 'Pos\PosController@ceksaldo');
                Route::get('/pos/ceksaldo/saldo/{npk}', 'Pos\CeksaldoController@ceksaldo');
            });
            Route::get('/pos/cekbarang/cek/{nomor}', 'Pos\HoldController@cekbarang');

            Route::get('/pos/kasir/laporan', 'Pos\PosController@laporan');
            Route::get('/pos/admin', 'Pos\AdminController@index');
            Route::get('/pos/kasir', 'Pos\DetailController@index');
            Route::get('/pos/kasir/bulan', 'Pos\DetailController@index1');
            Route::get('/pos/kasir/periodik', 'Pos\DetailController@periodik');





//            Route::get('/pos/autodebet/transaksi/{kartu}/{pin}/{noref}', 'Pos\CashController@ceksaldo');
//            Route::get('/pos/autodebets/{kartu}/{pin}/{noref}', 'Pos\PosController@totalsaldo');
//            Route::get('/pos/autodebet/trans/mulai/{kartunya}/{norefnya}', 'Pos\CashController@autodebet');


            // Route::get('/pos/kasir/hari/l/sum/{df}', 'Pos\DetailController@showha1');
//            Route::post('/pos/master/ohoo', 'Pos\IklanController@iklan');

            Route::get('/pos/menukasir', 'Pos\PosController@menukasir');
            Route::get('/test', 'Pos\HoldController@test');
//            Route::get('/inventory/import/barang', 'Pos\PosController@import');


            Route::get('/invoice/cetaknow', 'Pos\PosController@invoice');
//            Route::post('/inventory/import/barang/importnya', 'Master\BarangController@importnya');
//            Route::get('/inventory/import/barang/sample', 'Master\BarangController@sampleimport');

            Route::group(['middleware' => 'rolewas:pos/laporan/transaksi/retur'], function () {
                Route::get('/pos/laporan/transaksi/retur/', 'Pos\HoldController@lapretur');
                Route::get('/pos/laporan/penjualan/retur/hari/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@showall');
                Route::get('/pos/laporan/penjualan/retur/bulan/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@showtoday');
                Route::get('/pos/laporan/penjualan/retur/tahun/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@showrange');

                Route::get('/pos/laporan/penjualan/retur/barang/hari/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@allkasirall');
                Route::get('/pos/laporan/penjualan/retur/barang/bulan/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@allkasirtoday');
                Route::get('/pos/laporan/penjualan/retur/barang/tahun/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@allkasirrange');


                Route::get('/pos/laporan/penjualan/retur/hari/pdf/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@hari');
                Route::get('/pos/laporan/penjualan/retur/bulan/pdf/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@bulan');
                Route::get('/pos/laporan/penjualan/retur/tahun/pdf/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@tahun');

                Route::get('/pos/laporan/penjualan/retur/barang/hari/pdf/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@alltoallhari');
                Route::get('/pos/laporan/penjualan/retur/barang/bulan/pdf/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@alltoallbulan');
                Route::get('/pos/laporan/penjualan/retur/barang/tahun/pdf/{df}/{dt}/{cabang}/{jenis}', 'Pos\HoldController@alltoalltahun');
            });

            Route::get('/pos/laporan', 'Pos\PosController@laporanpenjualan');

            Route::group(['middleware' => 'rolewasc:pos/hpp/akumulasi'], function () {
                Route::get('pos/hpp/akumulasi', 'Pos\TestController@hitunghpp');
            });

            Route::get('pos/cetak', 'Pos\PosController@cetak');
            Route::get('/inventory/simpan/expired', 'Pos\BerhasilController@simpanexpired');

            Route::group(['middleware' => 'rolewas:pos/laporan/transaksi/penjualan'], function () {
                Route::get('/pos/laporan/transaksi/penjualan', 'Pos\BerhasilController@laporan');
                Route::get('/pos/laporan/penjualan/detail/{noreff}', 'Pos\BerhasilController@laporandetail');

                Route::get('/pos/laporan/days/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@kasirrangeday');
                Route::get('/pos/laporan/months/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@kasirrangemonth');
                Route::get('/pos/laporan/years/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@kasirrangeyear');

                Route::get('/pos/laporan/all/days/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@allrangeday');
                Route::get('/pos/laporan/all/months/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@allrangemonth');
                Route::get('/pos/laporan/all/years/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@allrangeyear');
            });

            Route::group(['middleware' => 'rolewas:pos/laporan/transaksi/anggota'], function () {
                Route::get('pos/laporan/transaksi/anggota', 'Pos\BerhasilController@anggota');
                Route::get('pos/anggota/detail/{noreff}/{npk}', 'Pos\BerhasilController@anggotadetail');

                Route::get('/pos/anggota/days/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@anggotarangeday');
                Route::get('/pos/anggota/months/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@anggotarangemonth');
                Route::get('/pos/anggota/years/{id}/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@anggotarangeyear');

                Route::get('/pos/anggota/all/days/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@allanggotarangeday');
                Route::get('/pos/anggota/all/months/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@allanggotarangemonth');
                Route::get('/pos/anggota/all/years/{df}/{dt}/{cabang}/{jenis}', 'Pos\BerhasilController@allanggotarangeyear');
            });

            Route::get('/pos/kasir/harian/kasir/cetak/{id}', 'Pos\BerhasilController@cetaknow');
            Route::get('/pos/master/promo', 'Pos\IklanController@promo');
            Route::get('/pos/master/promo/tambah', 'Pos\IklanController@promotambah');
            Route::post('/pos/master/promo/tambah/action', 'Pos\IklanController@saveheader');
            Route::get('pos/master/promo/tambah/pilih/produk/{id}', 'Pos\IklanController@promobarang');
            Route::get('pos/master/promo/get/{id}/{pilihan}/{header}', 'Pos\IklanController@get');
            Route::post('pos/master/promo/storebarang', 'Pos\IklanController@storebarang');

            Route::group(['middleware' => 'rolewas:pos/laporan/stok/barang'], function () {
                Route::get('pos/laporan/stok/barang', 'Pos\IklanController@stokbarang');
                Route::get('pos/laporan/stok', 'Pos\IklanController@stok');
                Route::get('pos/laporan/stok/barang/cari/{id}', 'Pos\IklanController@caribarang');
                Route::get('pos/laporan/stok/barang/preview/{id}', 'Pos\IklanController@previewbarang');
                Route::get('pos/laporan/stok/barang/pdf/cetak/{id}', 'Pos\IklanController@pdfbarangid');
                Route::get('pos/laporan/stok/barang/pdf/preview', 'Pos\BerhasilController@pdfbarangall');
            });

            Route::group(['middleware' => 'rolewas:pos/laporan/hpp'], function () {
                Route::get('pos/laporan/hpp', 'Pos\BerhasilController@hpp');
                Route::get('/pos/laporan/hpp/search/hari/{id}/{df}/{dt}', 'Pos\IklanController@searchday');
                Route::get('/pos/laporan/hpp/search/bulan/{id}/{df}/{dt}', 'Pos\IklanController@searchmonth');
                Route::get('/pos/laporan/hpp/search/tahun/{id}/{df}/{dt}', 'Pos\IklanController@searchyear');

                Route::get('/pos/laporan/hpp/search/hari/all/qdert/{df}/{dt}', 'Pos\IklanController@allsearchday');
                Route::get('/pos/laporan/hpp/search/bulan/all/qdert/{df}/{dt}', 'Pos\IklanController@allsearchmonth');
                Route::get('/pos/laporan/hpp/search/tahun/all/qdert/{df}/{dt}', 'Pos\IklanController@allsearchyear');

                Route::get('/pos/laporan/hpp/cetak/pdf/hari/{id}/{df}/{dt}', 'Pos\IklanController@cetakday');
                Route::get('/pos/laporan/hpp/cetak/pdf/bulan/{id}/{df}/{dt}', 'Pos\IklanController@cetakmonth');
                Route::get('/pos/laporan/hpp/cetak/pdf/tahun/{id}/{df}/{dt}', 'Pos\IklanController@cetakyear');

                Route::get('/pos/laporan/hpp/cetak/hari/{df}/{dt}', 'Pos\IklanController@allcetakday');
                Route::get('/pos/laporan/hpp/cetak/bulan/{df}/{dt}', 'Pos\IklanController@allcetakmonth');
                Route::get('/pos/laporan/hpp/cetak/tahun/{df}/{dt}', 'Pos\IklanController@allcetakyear');
            });

            Route::get('/pos/laporan/transaksi', 'Pos\PosController@transaksi');

            Route::group(['middleware' => 'rolewas:pos/laporan/rekap'], function () {
                Route::get('pos/laporan/transaksi/rekap', 'Pos\BerhasilController@rekap');

                Route::get('pos/laporan/rekap/transaksi/all/{token}', 'Pos\BerhasilController@rekapjenisall');
                Route::get('pos/laporan/rekap/transaksi/jenis/{jenis}/{token}', 'Pos\BerhasilController@rekapjenis');

                Route::get('pos/laporan/rekap/cabang/all/{token}', 'Pos\BerhasilController@rekapanggotaall');
                Route::get('pos/laporan/rekap/cabang/jenis/{jenis}/{token}', 'Pos\BerhasilController@rekapanggota');
                Route::get('pos/laporan/rekap/hari/{df}/{dt}/{token}', 'Pos\BerhasilController@hari');
                Route::get('pos/laporan/rekap/bulan/{df}/{dt}/{token}', 'Pos\BerhasilController@bulan');
                Route::get('pos/laporan/rekap/tahun/{df}/{dt}/{token}', 'Pos\BerhasilController@tahun');
            });

            Route::group(['middleware' => 'rolewas:pos/laporan/stok/barang'], function () {
                Route::get('/pos/laporan/stok/all/search/day/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@stokallday');
                Route::get('/pos/laporan/stok/all/search/month/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@stokallmonth');
                Route::get('/pos/laporan/stok/all/search/year/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@stokallyear');
            });

            Route::group(['middleware' => 'rolewas:pos/laporan/transaksi/fastmoving/slowmoving'], function () {
                Route::get('pos/laporan/transaksi/fastmoving/slowmoving', 'Pos\CeksaldoController@indexproduk');

                Route::get('/pos/laporan/stok/fastslow/search/day/{jenisnya}/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@stokday');
                Route::get('/pos/laporan/stok/fastslow/search/month/{jenisnya}/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@stokmonth');
                Route::get('/pos/laporan/stok/fastslow/search/year/{jenisnya}/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@stokyear');


                Route::get('/pos/laporan/stok/produk/fastslowall/hari/pdf/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@pdfstokallday');
                Route::get('/pos/laporan/stok/produk/fastslowall/bulan/pdf/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@pdfstokallmonth');
                Route::get('/pos/laporan/stok/produk/fastslowall/tahun/pdf/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@pdfstokallyear');

                Route::get('/pos/laporan/stok/produk/fastslow/hari/pdf/{jenisnya}/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@pdfstokday');
                Route::get('/pos/laporan/stok/produk/fastslow/bulan/pdf/{jenisnya}/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@pdfstokmonth');
                Route::get('/pos/laporan/stok/produk/fastslow/tahun/pdf/{jenisnya}/{df}/{dt}/{cabang}/{jenis}', 'Pos\CeksaldoController@pdfstokyear');
            });

            ///////////////////////////Inventory//////////////////////////////////////////////////////////////


            Route::get('/inventory', function () {
                return view('inventory.indeks');
            });

            //////////////////////////masterproduk////////////////////////////////////////////////////////////


//            Route::get('/masterproduk/search', 'Inventory\master\MasterProdukController@search');
//
//            Route::get('/tambahproduk', 'Inventory\master\MasterProdukController@showUnit');
//            Route::get('/tambahproduk/{idh}', 'Inventory\master\MasterProdukController@showUnit2');
//            Route::post('/tambahproduk/save', 'Inventory\master\MasterProdukController@store');
//
//            Route::get('/ubahproduk/{id}', 'Inventory\master\MasterProdukController@edit');
//            Route::post('/updateproduk/{id}', 'Inventory\master\MasterProdukController@update');
//            Route::get('/deleteproduk/{id}', 'Inventory\master\MasterProdukController@destroy');
//            Route::get('/masterproduk/cari/{barangnya}', 'Inventory\master\MasterProdukController@cari');
//            Route::get('/untung/{j}/{b}', 'Inventory\master\MasterProdukController@untung');
//            Route::get('/disc/{j}/{d}', 'Inventory\master\MasterProdukController@disc');


            ////////////////////////konfigurasi///////////////////////////////////////////////////////////////

//            Route::post('/masterkonfigurasi/save', 'Inventory\konfigurasi\MasterKonfigurasiController@store');
//
//            Route::get('/masterkonfigurasi', 'Inventory\konfigurasi\MasterKonfigurasiController@index');

            /////////////StokMinimum//////////////////////////////////////////////////////////
            Route::group(['middleware' => 'rolewas:stokminimum'], function () {
                Route::get('/stokminimum', 'Inventory\stok\StokMinimumController@showStok');
                Route::get('/stok/minimum/pdf/cetak', 'Inventory\stok\StokMinimumController@print_stok');
            });

            Route::group(['middleware' => 'rolewas:inventory/expired'], function () {
                Route::get('/inventory/expired', 'Inventory\stok\StokMinimumController@expired');
                Route::get('/expired/pdf/cetak', 'Inventory\stok\StokMinimumController@print_expired');
            });

            ///////////////////////LapProduk//////////////////////////////////////////////////
            Route::group(['middleware' => 'rolewas:lapbarangmasuk'], function () {
                Route::get('/lapbarangmasuk', 'Inventory\laporan\LapBarangMasukController@showProdukIn');
                Route::get('/pdf', 'Inventory\master\MasterProdukController@jumpdf');
            });
            Route::group(['middleware' => 'rolewas:lapbarangkeluar'], function () {
                Route::get('/pdf2', 'Inventory\master\MasterProdukController@jumpdf2');
                Route::get('/lapbarangkeluar', 'Inventory\laporan\LapBarangKeluarController@showProdukOut');
            });

            //////////////////////////////StockOpname/////////////////////////////////////////
//            Route::get('/stockopname', 'Inventory\stok\StockOpnameController@index');
//            Route::get('/stockopname/cari/{barangnya}', 'Inventory\stok\StockOpnameController@cari');

//            Route::get('/retur', 'Inventory\stok\ReturController@index');
//
//            Route::get('/invoice', function () {
//                return view('inventory.invoice');
//            });
//
//            Route::get('/pembelian', function () {
//                return view('inventory.pembelian');
//            });
//
//            Route::get('/blok', function () {
//                return view('inventory.underconstructed');
//            });
//
//
//            Route::get('/opname/cek/{id}', 'Inventory\stok\StockOpnameController@cek');
//            Route::get('/opname/save/{id}/{save}', 'Inventory\stok\StockOpnameController@store');
//
////            Route::get('/import', function () {
////                return view('master.barang.import_barang');
////            });
//
            Route::get('/detail/{id}', 'Inventory\master\MasterProdukController@liat');




            Route::group(['prefix' => 'inventory'], function () {
                Route::get('/masterproduk', 'Inventory\master\MasterProdukController@index');
                Route::group(['prefix' => 'cabang'], function () {
                    Route::group(['prefix' => 'penerimaan'], function () {
                        Route::group(['middleware' => 'rolewas:inventory/cabang/penerimaan'], function () {
                            Route::get('', 'Inventory\cabang\PenerimaanController@index');
                            Route::get('search', 'Inventory\cabang\PenerimaanController@search');
                            Route::get('detail/{id}', 'Inventory\cabang\PenerimaanController@detail');
                            Route::get('cetak/{id}', 'Inventory\cabang\PenerimaanController@cetak');
                        });
                        Route::group(['middleware' => 'rolewasc:inventory/cabang/penerimaan'], function () {
                            Route::get('ceknomor', 'Inventory\cabang\PenerimaanController@ceknomor');
                            Route::get('tambah', 'Inventory\cabang\PenerimaanController@create');
                            Route::post('storeheader', 'Inventory\cabang\PenerimaanController@storeheader');
                        });
                        Route::group(['middleware' => 'rolewasu:inventory/cabang/penerimaan'], function () {
                            Route::get('editheader/{id}', 'Inventory\cabang\PenerimaanController@editheader');
                            Route::post('updateheader/{id}', 'Inventory\cabang\PenerimaanController@updateheader');
                            Route::get('receive/{id}', 'Inventory\cabang\PenerimaanController@receive');
                            Route::post('storebarang', 'Inventory\cabang\PenerimaanController@storebarang');
                            Route::get('get/{id}/{pilihan}/{header}', 'Inventory\cabang\PenerimaanController@get');
                        });
                        Route::group(['middleware' => 'rolewasd:inventory/cabang/penerimaan'], function () {
                            Route::get('hapusheader/{id}', 'Inventory\cabang\PenerimaanController@destroyheader');
                            Route::get('hapusdetail/{id}/{header}', 'Inventory\cabang\PenerimaanController@destroydetail');
                        });
                    });

                    Route::group(['prefix' => 'pengiriman'], function () {
                        Route::group(['middleware' => 'rolewas:inventory/cabang/pengiriman'], function () {
                            Route::get('', 'Inventory\cabang\PengirimanController@index');
                            Route::get('search', 'Inventory\cabang\PengirimanController@search');
                            Route::get('detail/{id}', 'Inventory\cabang\PengirimanController@detail');
                            Route::get('cetak/{id}', 'Inventory\cabang\PengirimanController@cetak');
                        });
                        Route::group(['middleware' => 'rolewasc:inventory/cabang/pengiriman'], function () {
                            Route::get('ceknomor', 'Inventory\cabang\PengirimanController@ceknomor');
                            Route::get('tambah', 'Inventory\cabang\PengirimanController@create');
                            Route::post('storeheader', 'Inventory\cabang\PengirimanController@storeheader');
                            Route::get('get2/{id}/{pilihan}', 'Inventory\cabang\PengirimanController@get2');
                        });
                        Route::group(['middleware' => 'rolewasu:inventory/cabang/pengiriman'], function () {
                            Route::post('updateheader/{id}', 'Inventory\cabang\PengirimanController@updateheader');
                            Route::get('get/{id}/{pilihan}/{header}', 'Inventory\cabang\PengirimanController@get');
                            Route::get('editheader/{id}', 'Inventory\cabang\PengirimanController@editheader');
                            Route::post('storebarang', 'Inventory\cabang\PengirimanController@storebarang');
                        });
                        Route::group(['middleware' => 'rolewasd:inventory/cabang/pengiriman'], function () {
                            Route::get('hapusheader/{id}', 'Inventory\cabang\PengirimanController@destroyheader');
                            Route::get('hapusdetail/{id}/{header}', 'Inventory\cabang\PengirimanController@destroydetail');
                        });
                    });

                    Route::group(['prefix' => 'opname'], function () {
                        Route::group(['middleware' => 'rolewas:inventory/cabang/opname'], function () {
                            Route::get('', 'Inventory\cabang\OpnameController@index');
                            Route::get('search', 'Inventory\cabang\OpnameController@search');
                            Route::get('detail/{id}', 'Inventory\cabang\OpnameController@detail');
                            Route::get('cetak/{id}', 'Inventory\cabang\OpnameController@cetak');
                        });
                        Route::group(['middleware' => 'rolewasc:inventory/cabang/opname'], function () {
                            Route::get('ceknomor', 'Inventory\cabang\OpnameController@ceknomor');
                            Route::get('tambah', 'Inventory\cabang\OpnameController@create');
                            Route::post('storebarang', 'Inventory\cabang\OpnameController@storebarang');
                            Route::post('storeheader', 'Inventory\cabang\OpnameController@storeheader');
                            Route::get('get2/{id}/{pilihan}', 'Inventory\cabang\OpnameController@get2');
                        });
                        Route::group(['middleware' => 'rolewasu:inventory/cabang/opname'], function () {
                            Route::get('get/{id}/{pilihan}/{header}', 'Inventory\cabang\OpnameController@get');
                            Route::get('editheader/{id}', 'Inventory\cabang\OpnameController@editheader');
                            Route::post('updateheader/{id}', 'Inventory\cabang\OpnameController@updateheader');

                            Route::post('adjust', 'Inventory\cabang\OpnameController@adjustment');
                            Route::get('cek/{idh}/{barcode}', 'Inventory\cabang\OpnameController@cekbarcode');
                            Route::get('opname/{id}', 'Inventory\cabang\OpnameController@opname');
                            Route::get('history/{id}', 'Inventory\cabang\OpnameController@opnamehistory');
                        });
                        Route::group(['middleware' => 'rolewasd:inventory/cabang/opname'], function () {
                            Route::get('hapusheader/{id}', 'Inventory\cabang\OpnameController@destroyheader');
                            Route::get('hapusdetail/{id}/{header}', 'Inventory\cabang\OpnameController@destroydetail');
                        });

                    });
                });
//                Route::get('cabang/pindah', 'Inventory\master\PindahCabangController@index');
//                Route::post('cabang/pindah', 'Inventory\master\PindahCabangController@store');

                Route::group(['prefix' => 'supplier'], function () {
                    Route::group(['prefix' => 'pembelian'], function () {
                        Route::group(['middleware' => 'rolewas:inventory/supplier/pembelian'], function () {
                            Route::get('', 'Inventory\supllier\PembelianController@index');
                            Route::get('search', 'Inventory\supllier\PembelianController@search');
                            Route::get('detail/{id}', 'Inventory\supllier\PembelianController@detail');
                            Route::get('porder/{id}', 'Inventory\supllier\PembelianController@porder');
                            Route::get('cetak/{id}', 'Inventory\supllier\PembelianController@excelbeli');
                        });
                        Route::group(['middleware' => 'rolewasc:inventory/supplier/pembelian'], function () {
                            Route::get('ceknomor', 'Inventory\supllier\PembelianController@ceknomor');
                            Route::get('tambah', 'Inventory\supllier\PembelianController@create');
                            Route::post('storeheader', 'Inventory\supllier\PembelianController@storeheader');
                            Route::get('get2/{id}/{pilihan}', 'Inventory\supllier\PembelianController@get2');
                        });
                        Route::group(['middleware' => 'rolewasu:inventory/supplier/pembelian'], function () {
                            Route::post('updateheader/{id}', 'Inventory\supllier\PembelianController@updateheader');
                            Route::get('editheader/{id}', 'Inventory\supllier\PembelianController@editheader');
                            Route::post('storebarang', 'Inventory\supllier\PembelianController@storebarang');
                            Route::get('get/{id}/{pilihan}/{header}', 'Inventory\supllier\PembelianController@get');
                        });
                        Route::group(['middleware' => 'rolewasd:inventory/supplier/pembelian'], function () {
                            Route::get('hapusheader/{id}', 'Inventory\supllier\PembelianController@destroyheader');
                            Route::get('hapusdetail/{id}/{header}', 'Inventory\supllier\PembelianController@destroydetail');
                        });
                    });

                    Route::group(['prefix' => 'penerimaan'], function () {
                        Route::group(['middleware' => 'rolewas:inventory/supplier/penerimaan'], function () {
                            Route::get('', 'Inventory\supllier\PenerimaanController@index');
                            Route::get('search', 'Inventory\supllier\PenerimaanController@search');
                            Route::get('detail/{id}', 'Inventory\supllier\PenerimaanController@detail');
                            Route::get('cetak/{id}', 'Inventory\supllier\PenerimaanController@cetak');
                        });
                        Route::group(['middleware' => 'rolewasc:inventory/supplier/penerimaan'], function () {
                            Route::get('ceknomor', 'Inventory\supllier\PenerimaanController@ceknomor');
                            Route::get('tambah', 'Inventory\supllier\PenerimaanController@create');
                            Route::post('storeheader', 'Inventory\supllier\PenerimaanController@storeheader');
                        });
                        Route::group(['middleware' => 'rolewasu:inventory/supplier/penerimaan'], function () {
                            Route::post('updateheader/{id}', 'Inventory\supllier\PenerimaanController@updateheader');
                            Route::get('editheader/{id}', 'Inventory\supllier\PenerimaanController@editheader');
                            Route::post('updatedetail/{id}', 'Inventory\supllier\PenerimaanController@updatedetail');
                            Route::post('storebarang', 'Inventory\supllier\PenerimaanController@storebarang');
                            Route::get('receive/{id}', 'Inventory\supllier\PenerimaanController@receive');
                            Route::get('get/{id}/{pilihan}/{header}', 'Inventory\supllier\PenerimaanController@get');
                        });
                        Route::group(['middleware' => 'rolewasd:inventory/supplier/penerimaan'], function () {
                            Route::get('hapusheader/{id}', 'Inventory\supllier\PenerimaanController@destroyheader');
                            Route::get('hapusdetail/{id}/{header}', 'Inventory\supllier\PenerimaanController@destroydetail');
                        });
                    });

                    Route::group(['prefix' => 'retur'], function () {
                        Route::group(['middleware' => 'rolewas:inventory/supplier/retur'], function () {
                            Route::get('', 'Inventory\supllier\ReturController@index');
                            Route::get('search', 'Inventory\supllier\ReturController@search');
                            Route::get('detail/{id}', 'Inventory\supllier\ReturController@detail');
                            Route::get('cetak/{id}', 'Inventory\supllier\ReturController@cetak');
                        });
                        Route::group(['middleware' => 'rolewasc:inventory/supplier/retur'], function () {
                            Route::get('ceknomor', 'Inventory\supllier\ReturController@ceknomor');
                            Route::get('tambah', 'Inventory\supllier\ReturController@create');
                            Route::post('storeheader', 'Inventory\supllier\ReturController@storeheader');
                            Route::get('get2/{id}/{pilihan}', 'Inventory\supllier\ReturController@get2');
                        });
                        Route::group(['middleware' => 'rolewasu:inventory/supplier/retur'], function () {
                            Route::get('editheader/{id}', 'Inventory\supllier\ReturController@editheader');
                            Route::post('storebarang', 'Inventory\supllier\ReturController@storebarang');
                            Route::get('get/{id}/{pilihan}/{header}', 'Inventory\supllier\ReturController@get');
                            Route::post('updateheader/{id}', 'Inventory\supllier\ReturController@updateheader');
                            Route::get('prosesretur/{idh}', 'Inventory\supllier\ReturController@prosesretur');
                        });
                        Route::group(['middleware' => 'rolewasd:inventory/supplier/retur'], function () {
                            Route::get('hapusheader/{id}', 'Inventory\supllier\ReturController@destroyheader');
                            Route::get('hapusdetail/{id}/{header}', 'Inventory\supllier\ReturController@destroydetail');
                        });
                    });
                });

            });
        });

    });

    Route::get('/', 'Dashboard\DashboardController@home');
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::post('login', 'Auth\AuthController@postLogin');
    Route::get('logout', 'Auth\AuthController@getLogout');

});
