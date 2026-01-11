<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Word;
use App\Models\Definition;
use Carbon\Carbon;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            // Gen-Z Category
            [
                'term' => 'Rizz',
                'category' => 'Gen-Z',
                'definitions' => [
                    [
                        'definition' => 'Charisma or charm that someone uses to attract romantic interest. Short for "charisma."',
                        'example' => 'Did you see how he talked to her? He\'s got that rizz!',
                        'submitted_by' => 'GenZKing',
                        'agrees' => 2847,
                        'disagrees' => 143,
                        'hours_old' => 2.5
                    ],
                    [
                        'definition' => 'The ability to flirt and attract people effortlessly.',
                        'example' => 'She has unspoken rizz, doesn\'t even try.',
                        'submitted_by' => 'RizzMaster',
                        'agrees' => 1523,
                        'disagrees' => 89,
                        'hours_old' => 4.0
                    ],
                    [
                        'definition' => 'Game or charisma used to impress someone.',
                        'example' => 'Bro pulled her in 2 mins — crazy rizz.',
                        'submitted_by' => 'SmoothTalker',
                        'agrees' => 1200,
                        'disagrees' => 90,
                        'hours_old' => 6.0
                    ]
                ]
            ],
            [
                'term' => 'Gyatt',
                'category' => 'Gen-Z',
                'definitions' => [
                    [
                        'definition' => 'Exclamation used when seeing an attractive person, especially their physique.',
                        'example' => 'He walked in and everyone went GYATT!',
                        'submitted_by' => 'TikTokLord',
                        'agrees' => 4521,
                        'disagrees' => 234,
                        'hours_old' => 1.0
                    ]
                ]
            ],
            [
                'term' => 'Skibidi',
                'category' => 'Gen-Z',
                'definitions' => [
                    [
                        'definition' => 'A viral meme from Skibidi Toilet YouTube series, used as random Gen-Z slang.',
                        'example' => 'That\'s so skibidi toilet of you.',
                        'submitted_by' => 'MemeKing',
                        'agrees' => 3892,
                        'disagrees' => 1567,
                        'hours_old' => 0.5
                    ]
                ]
            ],
            [
                'term' => 'Ohio',
                'category' => 'Gen-Z',
                'definitions' => [
                    [
                        'definition' => 'Used to describe something weird, cursed, or bizarre.',
                        'example' => 'Only in Ohio would you see that.',
                        'submitted_by' => 'OhioMeme',
                        'agrees' => 2341,
                        'disagrees' => 456,
                        'hours_old' => 3.0
                    ]
                ]
            ],
            [
                'term' => 'FR FR',
                'category' => 'Gen-Z',
                'definitions' => [
                    [
                        'definition' => 'Short for "for real, for real" - emphasizing that you\'re being serious.',
                        'example' => 'This is the best pizza I\'ve ever had, fr fr.',
                        'submitted_by' => 'TruthTeller',
                        'agrees' => 5692,
                        'disagrees' => 234,
                        'hours_old' => 0.5
                    ]
                ]
            ],
            [
                'term' => 'Mid',
                'category' => 'Gen-Z',
                'definitions' => [
                    [
                        'definition' => 'Mediocre, not good but not terrible either. Just average.',
                        'example' => 'That new album was mid, tbh.',
                        'submitted_by' => 'MusicCritic',
                        'agrees' => 1567,
                        'disagrees' => 234,
                        'hours_old' => 4.5
                    ],
                    [
                        'definition' => 'Disappointingly average when you expected better.',
                        'example' => 'The hype was crazy but the game is just mid.',
                        'submitted_by' => 'GamerDude',
                        'agrees' => 987,
                        'disagrees' => 145,
                        'hours_old' => 7.0
                    ]
                ]
            ],

            // TikTok Category
            [
                'term' => 'Delulu',
                'category' => 'TikTok',
                'definitions' => [
                    [
                        'definition' => 'Being delusional, especially in relationships or unrealistic expectations.',
                        'example' => 'Thinking your crush likes you back when they don\'t even follow you? That\'s delulu.',
                        'submitted_by' => 'RealityCheck',
                        'agrees' => 4872,
                        'disagrees' => 124,
                        'hours_old' => 1.0
                    ],
                    [
                        'definition' => 'Having unrealistic dreams or fantasies.',
                        'example' => 'Delulu is the solulu (solution).',
                        'submitted_by' => 'DreamerGirl',
                        'agrees' => 2341,
                        'disagrees' => 89,
                        'hours_old' => 3.0
                    ]
                ]
            ],
            [
                'term' => 'NPC',
                'category' => 'TikTok',
                'definitions' => [
                    [
                        'definition' => 'Someone who acts robotic or scripted, like a non-player character in a video game.',
                        'example' => 'He just stands there nodding, total NPC behavior.',
                        'submitted_by' => 'GamerBrain',
                        'agrees' => 3456,
                        'disagrees' => 567,
                        'hours_old' => 2.0
                    ]
                ]
            ],
            [
                'term' => 'Understood the Assignment',
                'category' => 'TikTok',
                'definitions' => [
                    [
                        'definition' => 'Exceeded expectations, did exactly what was needed and more.',
                        'example' => 'Her red carpet look? She understood the assignment.',
                        'submitted_by' => 'FashionWeek',
                        'agrees' => 3254,
                        'disagrees' => 123,
                        'hours_old' => 0.75
                    ]
                ]
            ],
            [
                'term' => 'Main Character Energy',
                'category' => 'TikTok',
                'definitions' => [
                    [
                        'definition' => 'Acting like you\'re the protagonist of your own movie, confident and attention-grabbing.',
                        'example' => 'She walked in with main character energy.',
                        'submitted_by' => 'MovieStar',
                        'agrees' => 2876,
                        'disagrees' => 234,
                        'hours_old' => 4.0
                    ]
                ]
            ],
            [
                'term' => 'Demure',
                'category' => 'TikTok',
                'definitions' => [
                    [
                        'definition' => 'Being modest, reserved, and mindful. Viral from Jools Lebron TikTok.',
                        'example' => 'Very demure, very mindful, very cutesy.',
                        'submitted_by' => 'DemureQueen',
                        'agrees' => 6543,
                        'disagrees' => 321,
                        'hours_old' => 0.25
                    ]
                ]
            ],
            [
                'term' => 'Brat Summer',
                'category' => 'TikTok',
                'definitions' => [
                    [
                        'definition' => 'Living unapologetically, being messy and chaotic in a fun way.',
                        'example' => 'It\'s brat summer, I\'m not apologizing for anything.',
                        'submitted_by' => 'CharliXCXFan',
                        'agrees' => 4521,
                        'disagrees' => 567,
                        'hours_old' => 1.5
                    ]
                ]
            ],

            // AAVE Category
            [
                'term' => 'Slay',
                'category' => 'AAVE',
                'definitions' => [
                    [
                        'definition' => 'To do something exceptionally well or look amazing.',
                        'example' => 'Your outfit is slaying today!',
                        'submitted_by' => 'FashionIcon',
                        'agrees' => 1234,
                        'disagrees' => 12,
                        'hours_old' => 6.0
                    ],
                    [
                        'definition' => 'To kill it, excel at something with style.',
                        'example' => 'She slayed that presentation.',
                        'submitted_by' => 'Anonymous',
                        'agrees' => 892,
                        'disagrees' => 45,
                        'hours_old' => 8.0
                    ]
                ]
            ],
            [
                'term' => 'Bussin',
                'category' => 'AAVE',
                'definitions' => [
                    [
                        'definition' => 'Extremely good, especially food that tastes amazing.',
                        'example' => 'This chicken sandwich is bussin!',
                        'submitted_by' => 'Foodie2024',
                        'agrees' => 892,
                        'disagrees' => 67,
                        'hours_old' => 3.0
                    ],
                    [
                        'definition' => 'Something that slaps or hits different in the best way.',
                        'example' => 'These fries are straight bussin, no cap.',
                        'submitted_by' => 'TasteTest',
                        'agrees' => 654,
                        'disagrees' => 34,
                        'hours_old' => 5.5
                    ]
                ]
            ],
            [
                'term' => 'No Cap',
                'category' => 'AAVE',
                'definitions' => [
                    [
                        'definition' => 'No lie, for real, being completely honest.',
                        'example' => 'That\'s the best movie I\'ve seen this year, no cap.',
                        'submitted_by' => 'KeepingItReal',
                        'agrees' => 3421,
                        'disagrees' => 156,
                        'hours_old' => 1.5
                    ]
                ]
            ],
            [
                'term' => 'Ate',
                'category' => 'AAVE',
                'definitions' => [
                    [
                        'definition' => 'Did something perfectly, crushed it, left no crumbs.',
                        'example' => 'Beyoncé ate that performance, no one can compete.',
                        'submitted_by' => 'StanAccount',
                        'agrees' => 1876,
                        'disagrees' => 67,
                        'hours_old' => 1.25
                    ]
                ]
            ],
            [
                'term' => 'Period',
                'category' => 'AAVE',
                'definitions' => [
                    [
                        'definition' => 'Emphasizing a statement as final and undebatable.',
                        'example' => 'She\'s the best singer of our generation, period.',
                        'submitted_by' => 'BeyhiveMember',
                        'agrees' => 2341,
                        'disagrees' => 123,
                        'hours_old' => 2.5
                    ]
                ]
            ],

            // Gaming Category
            [
                'term' => 'Hard Carry',
                'category' => 'Gaming',
                'definitions' => [
                    [
                        'definition' => 'When one player single-handedly wins the game for their team.',
                        'example' => 'I had to hard carry my team in ranked.',
                        'submitted_by' => 'ProGamer',
                        'agrees' => 1567,
                        'disagrees' => 89,
                        'hours_old' => 2.0
                    ]
                ]
            ],
            [
                'term' => 'GG',
                'category' => 'Gaming',
                'definitions' => [
                    [
                        'definition' => 'Good game - said at the end of a match to show sportsmanship.',
                        'example' => 'That was intense, GG everyone!',
                        'submitted_by' => 'EsportsLegend',
                        'agrees' => 4521,
                        'disagrees' => 34,
                        'hours_old' => 0.5
                    ]
                ]
            ],
            [
                'term' => 'Rage Bait',
                'category' => 'Gaming',
                'definitions' => [
                    [
                        'definition' => 'Content designed to make people angry and engage.',
                        'example' => 'Don\'t fall for rage bait, it\'s just for views.',
                        'submitted_by' => 'ContentCreator',
                        'agrees' => 2341,
                        'disagrees' => 567,
                        'hours_old' => 3.0
                    ]
                ]
            ],
            [
                'term' => 'Touch Grass',
                'category' => 'Gaming',
                'definitions' => [
                    [
                        'definition' => 'Go outside, take a break from the internet.',
                        'example' => 'You\'ve been gaming for 12 hours, go touch grass.',
                        'submitted_by' => 'HealthyGamer',
                        'agrees' => 3456,
                        'disagrees' => 234,
                        'hours_old' => 1.0
                    ]
                ]
            ],
            [
                'term' => 'Nerf',
                'category' => 'Gaming',
                'definitions' => [
                    [
                        'definition' => 'When game developers make something weaker or less powerful.',
                        'example' => 'They nerfed my main character again!',
                        'submitted_by' => 'BalancePatch',
                        'agrees' => 1876,
                        'disagrees' => 123,
                        'hours_old' => 4.0
                    ]
                ]
            ],

            // Internet/Memes Category
            [
                'term' => 'Sigma',
                'category' => 'Internet',
                'definitions' => [
                    [
                        'definition' => 'A lone wolf type person who doesn\'t follow social hierarchies.',
                        'example' => 'He\'s on his sigma grindset, doing his own thing.',
                        'submitted_by' => 'AlphaMale2024',
                        'agrees' => 2341,
                        'disagrees' => 567,
                        'hours_old' => 2.0
                    ]
                ]
            ],
            [
                'term' => 'Simp',
                'category' => 'Internet',
                'definitions' => [
                    [
                        'definition' => 'Someone who does too much for someone they like, often embarrassingly so.',
                        'example' => 'He bought her a $200 gift after one date? Total simp.',
                        'submitted_by' => 'DatingCoach',
                        'agrees' => 4532,
                        'disagrees' => 892,
                        'hours_old' => 3.5
                    ],
                    [
                        'definition' => 'To do excessive things to get someone\'s attention or affection.',
                        'example' => 'Stop simping and focus on yourself.',
                        'submitted_by' => 'RedPillGuy',
                        'agrees' => 2156,
                        'disagrees' => 678,
                        'hours_old' => 6.5
                    ]
                ]
            ],
            [
                'term' => 'Cooked',
                'category' => 'Internet',
                'definitions' => [
                    [
                        'definition' => 'Destroyed, finished, ruined beyond repair.',
                        'example' => 'After that tweet came out, his career is cooked.',
                        'submitted_by' => 'TwitterWatcher',
                        'agrees' => 3421,
                        'disagrees' => 234,
                        'hours_old' => 1.0
                    ]
                ]
            ],
            [
                'term' => 'Goated',
                'category' => 'Internet',
                'definitions' => [
                    [
                        'definition' => 'Being the greatest of all time (GOAT) at something.',
                        'example' => 'LeBron is goated in basketball.',
                        'submitted_by' => 'SportsHead',
                        'agrees' => 2876,
                        'disagrees' => 567,
                        'hours_old' => 2.5
                    ]
                ]
            ],
            [
                'term' => 'It\'s Giving',
                'category' => 'Memes',
                'definitions' => [
                    [
                        'definition' => 'It resembles or reminds of something specific.',
                        'example' => 'Your outfit? It\'s giving CEO.',
                        'submitted_by' => 'FashionTok',
                        'agrees' => 2341,
                        'disagrees' => 123,
                        'hours_old' => 3.0
                    ]
                ]
            ],
            [
                'term' => 'Bombastic Side Eye',
                'category' => 'Memes',
                'definitions' => [
                    [
                        'definition' => 'A dramatic, exaggerated side eye look showing disapproval.',
                        'example' => 'She gave me the bombastic side eye after I said that.',
                        'submitted_by' => 'MemeLord',
                        'agrees' => 4567,
                        'disagrees' => 234,
                        'hours_old' => 0.5
                    ]
                ]
            ],
            [
                'term' => 'Quiet Luxury',
                'category' => 'Memes',
                'definitions' => [
                    [
                        'definition' => 'Understated wealth, expensive items without flashy logos.',
                        'example' => 'Quiet luxury is just saying you\'re rich without being loud.',
                        'submitted_by' => 'MoneyMoves',
                        'agrees' => 1876,
                        'disagrees' => 456,
                        'hours_old' => 4.0
                    ]
                ]
            ],
            [
                'term' => 'Core',
                'category' => 'Memes',
                'definitions' => [
                    [
                        'definition' => 'Suffix added to describe an aesthetic or vibe.',
                        'example' => 'This room is giving cottagecore vibes.',
                        'submitted_by' => 'AestheticQueen',
                        'agrees' => 2341,
                        'disagrees' => 123,
                        'hours_old' => 2.0
                    ]
                ]
            ],

            // Slang Category
            [
                'term' => 'W',
                'category' => 'Slang',
                'definitions' => [
                    [
                        'definition' => 'Win. Used to celebrate a victory or success.',
                        'example' => 'Got the job offer, that\'s a W!',
                        'submitted_by' => 'WinnerMentality',
                        'agrees' => 5432,
                        'disagrees' => 123,
                        'hours_old' => 0.5
                    ]
                ]
            ],
            [
                'term' => 'L',
                'category' => 'Slang',
                'definitions' => [
                    [
                        'definition' => 'Loss. Used when something goes wrong or someone fails.',
                        'example' => 'Tripped in front of everyone, massive L.',
                        'submitted_by' => 'HumbleBrag',
                        'agrees' => 4321,
                        'disagrees' => 234,
                        'hours_old' => 1.0
                    ]
                ]
            ],
            [
                'term' => 'Lowkey',
                'category' => 'Slang',
                'definitions' => [
                    [
                        'definition' => 'Secretly, somewhat, or on the down-low.',
                        'example' => 'I lowkey want to go to that party.',
                        'submitted_by' => 'SubtleVibes',
                        'agrees' => 2341,
                        'disagrees' => 89,
                        'hours_old' => 3.0
                    ]
                ]
            ],
            [
                'term' => 'Highkey',
                'category' => 'Slang',
                'definitions' => [
                    [
                        'definition' => 'Openly, obviously, without hiding.',
                        'example' => 'I highkey love this song, no shame.',
                        'submitted_by' => 'LoudAndProud',
                        'agrees' => 1876,
                        'disagrees' => 67,
                        'hours_old' => 2.5
                    ]
                ]
            ],
            [
                'term' => 'Stan',
                'category' => 'Slang',
                'definitions' => [
                    [
                        'definition' => 'A super passionate fan, from Eminem\'s song "Stan".',
                        'example' => 'I stan Taylor Swift, no questions asked.',
                        'submitted_by' => 'SwiftieForever',
                        'agrees' => 3456,
                        'disagrees' => 234,
                        'hours_old' => 1.5
                    ]
                ]
            ],
            [
                'term' => 'Tea',
                'category' => 'Slang',
                'definitions' => [
                    [
                        'definition' => 'Gossip, drama, or juicy information.',
                        'example' => 'Spill the tea, what happened?',
                        'submitted_by' => 'GossipGirl',
                        'agrees' => 4567,
                        'disagrees' => 123,
                        'hours_old' => 0.75
                    ]
                ]
            ],
        ];

        foreach ($words as $wordData) {
            $word = Word::create([
                'term' => $wordData['term'],
                'category' => $wordData['category'],
            ]);

            foreach ($wordData['definitions'] as $defData) {
                $createdAt = Carbon::now()->subHours($defData['hours_old']);
                
                $definition = Definition::create([
                    'word_id' => $word->id,
                    'definition' => $defData['definition'],
                    'example' => $defData['example'],
                    'submitted_by' => $defData['submitted_by'],
                    'agrees' => $defData['agrees'],
                    'disagrees' => $defData['disagrees'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Update velocity score
                $definition->updateVelocityScore();
            }

            // Recalculate word stats
            $word->recalculateStats();
        }
    }
}
