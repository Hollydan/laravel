<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //获取 Faker 实例
        $faker = app(Faker\Generator::class);

        //头像假数据
        $avatars = [
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/s5ehp11z6s.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/Lhd1SHqu86.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/LOnMrqbHJn.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/xAuDMxteQy.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/ZqM7iaP4CR.png?imageView2/1/w/200/h/200',
            'https://fsdhubcdn.phphub.org/uploads/images/201710/14/1/NDnzMutoxX.png?imageView2/1/w/200/h/200',
        ];

        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function ($user, $index)use ($faker, $avatars) {
                            //从头像数组中随机取出一个并赋值
                            $user->avatar = $faker->randomElement($avatars);
                        });

        //让隐藏字段可见，并将数据集合转换为数组
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        //插入数据库
        User::insert($user_array);

        //初始化用户角色，1 号用户设为站长
        $user = User::find(11);
        $user->assignRole('Founder');

        // 2 号用户为管理员
        $user = User::find(12);
        $user->assignRole('Maintainer');
    }
}
