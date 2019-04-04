<?php 

return [
	'menu_header' => [
		/* NOTE : 
		* url 	= for condition active which is use function requeset()->is() in helper
		* name 	= for show in view menu header
		* link 	= for tag a and function is what redirect to
		* title = just title for this menu
		* class = for name class by that menu
		* child = for sub menu
		*/
		0 => [
			 
			'name' 	=> 'Akad Baru', 
			'icon'	=> 'feather icon-file-plus',
			'route'	=> 'akad.create',
			'title'	=> 'akad',
			'class' => false,
			'child'	=> false,
		],
		1 => [
			'name' 	=> 'Cabang',
			'icon'	=> 'feather icon-list',
			'route'	=> false,
			'title'	=> 'cabang',
			'class' => 'pcoded-hasmenu',
			'child'	=> [
				0	=> [
					'url'	=> 'cabang/create',
					'name'	=> 'Tambah Cabang',
					'route'	=> 'cabang.create',
				],
				1	=> [
					'url'	=> 'cabang/edit',
					'name'	=> 'Edit Cabang',
					'route'	=> 'cabang.edit',
				],
				2	=> [
					'url'	=> 'cabang',
					'name'	=> 'Data Cabang',
					'route'	=> 'cabang.index',
				],
			],
		],
		2 => [
			'name' 	=> 'Database',
			'icon'	=> 'icofont icofont-database',
			'route'	=> false,
			'title'	=> 'database',
			'class' => 'pcoded-hasmenu',
			'child'	=> [
				0	=> [
					'url'	=> false,
					'name'	=> 'Database Nasabah',
					'route'	=> false,
				],
				1	=> [
					'url'	=> 'akad',
					'name'	=> 'Data Akad Nasabah',
					'route'	=> 'akad.index',
				],
			],
		],
	],
	'select_by' => [
		'akad_nasabah' => [
			'nama',
			'no_telp',
			'no_id',
			'jaminan',
			'pinjaman',
			'tunggakan',
			'tanggal_akad',
			'jatuh_tempo',
			'prosedur',
		],
	],
];