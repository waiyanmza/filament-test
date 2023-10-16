<?php

namespace App\Filament\Resources;

use App\Models\Nrc;
use Filament\Forms;
use App\Models\Info;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\InfoResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InfoResource\RelationManagers;

class InfoResource extends Resource
{
    protected static ?string $model = Info::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Step::make('Employee Info')
                        ->schema([
                            TextInput::make('eng_name')->required()
                            ->label('Employee Name(eng)')
                            ->placeholder('Employee Name(eng)')
                            ->columnSpan(4),
                            TextInput::make('mm_name')->required()
                            ->label('Employee Name(mm)')
                            ->placeholder('Employee Name(mm)')
                            ->columnSpan(4),
                            TextInput::make('pap_name')->required()
                            ->label('Father Name')
                            ->placeholder('Father Name(mm)')
                            ->columnSpan(4),

                            DatePicker::make('dob')->required()
                            ->label('Date of Birth')
                            ->placeholder('Date of Birth')
                            ->columnSpan(4),
                            TextInput::make('race')->required()
                            ->label('Race')
                            ->placeholder('Race')
                            ->columnSpan(4),

                            TextInput::make('driver_license')->required()
                            ->label('Driver License')
                            ->placeholder('Driver License')
                            ->columnSpan(4),
                            TextInput::make('home_phone')->required()
                            ->label('Home Phone')
                            ->placeholder('Home Phone')
                            ->columnSpan(4),
                            TextInput::make('mobile_phone')->required()
                            ->label('Mobile Phone')
                            ->placeholder('Mobile Phone')
                            ->columnSpan(4),

                            TextInput::make('Passport_NO')
                            ->label('Passport Number')
                            ->placeholder('Passport Number')
                            ->required()
                            ->columnSpan(4),

                            Select::make('Gender')
                                ->label('Gender')
                                ->placeholder('Gender')
                                ->required()
                                ->columnSpan(4)
                                ->options([
                                    'Male' => 'Male',
                                    'Female' => 'Female',
                                    'WRUG' => 'WRUG',
                                ]),

                            Select::make('nrcs_id')
                                    ->label('12/')
                                    ->live()
                                    ->options(Nrc::select('nrc_code')->distinct()->orderBy('nrc_code', 'asc')->pluck('nrc_code'))
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('name_en',
                                     Nrc::select('name_en')->where('nrc_code', ++$state)->pluck('name_en'))),

                            Select::make('nrcs_name')
                                    ->label('oukama')
                                    ->options(function ($get){
                                        return $get('name_en');
                                    })
                                    ->columnSpan(1),
                            Select::make('naing_id')
                                    ->label('နိုင်')
                                    ->placeholder('နိုင်')
                                    ->required()
                                    ->columnSpan(1)
                                    ->options([
                                        'n' => 'နိုင်',
                                        'p' => 'ပြု',
                                        'e' => 'ဧည့်',
                                    ]),
                            TextInput::make('nrc_number')
                                    ->label('number')
                                    ->placeholder('number')
                                    ->required()
                                    ->columnSpan(1),
                            Select::make('Marital_Status')
                                    ->label('Marital Status')
                                    ->placeholder('Marital Status')
                                    ->required()
                                    ->columnSpan(4)
                                    ->options([
                                        'Single' => 'Single',
                                        'Relationship' => 'Relationship',
                                        'Married' => 'Married',
                                    ]),

                            Select::make('religion_id')
                                    ->label('Religion')
                                    ->placeholder('Religion')
                                    ->required()
                                    ->columnSpan(4)
                                    ->options([
                                        'Believer' => 'Believer',
                                        'Non-Believer' => 'Non-Believer',
                                    ]),
                            Select::make('blood_id')
                                    ->label('Blood Type')
                                    ->placeholder('Blood Type')
                                    ->required()
                                    ->columnSpan(4)
                                    ->options([
                                        'A' => 'A',
                                        'A+' => 'A+',
                                        'B' => 'B',
                                        'B+' => 'B+',
                                        'AB' => 'AB',
                                        'AB+' => 'AB+',
                                        'O' => 'O',
                                        'O+' => 'O+',
                                    ]),
                            Select::make('nationality_id')
                                    ->label('nationality_id')
                                    ->placeholder('Nationality')
                                    ->required()
                                    ->columnSpan(4)
                                    ->options([
                                        'Internationnal' => 'Internationnal',
                                        'Local' => 'Local',
                                    ]),
                            Select::make('vacancy_id')
                                    ->label('Vacancy')
                                    ->placeholder('Vacancy')
                                    ->required()
                                    ->columnSpan(4)
                                    ->options([
                                        'frontend' => 'Frontend',
                                        'backend' => 'Backend',
                                        'fullstack' => 'Fullstack',
                                    ]),
                            TextInput::make('Social_Media_URL')
                                    ->label('Social Media')
                                    ->placeholder('Social Media URL')
                                    ->required()
                                    ->columnSpan(8),
                        ])->columns(12),

                    Step::make('Background Info')
                        ->schema([

                            Repeater::make('education')
                                ->relationship()
                                ->schema([

                                    TextInput::make('degree')
                                    ->label('Education/Degree')
                                    ->required()
                                    ->columnSpan(2),
                                    DatePicker::make('from')
                                    ->label('From')
                                    ->required()
                                    ->columnSpan(1),
                                    DatePicker::make('to')
                                    ->label('To')
                                    ->required()
                                    ->columnSpan(1),
                                    TextInput::make('school')
                                    ->label('School/Collage/University')
                                    ->required()
                                    ->columnSpan(2),

                                ])->columnSpanFull()->columns(6),

                            Repeater::make('work_exp')
                                ->relationship()
                                ->schema([
                                        Checkbox::make('work')
                                        ->label('Working Experience')
                                        ->columnSpanFull(),
                                        TextInput::make('job_title')
                                        ->hiddenLabel('job_title')
                                        ->placeholder('Job Title')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('company_name')
                                        ->hiddenLabel('company_name')
                                        ->placeholder('Company Name')
                                        ->required()
                                        ->columnSpan(2),
                                        DatePicker::make('work_from')
                                        ->hiddenLabel('work_from')
                                        ->placeholder('From')
                                        ->required()
                                        ->columnSpan(1),
                                        DatePicker::make('work_to')
                                        ->hiddenLabel('work_to')
                                        ->placeholder('To')
                                        ->required(),
                                        TextInput::make('work_contact')
                                        ->hiddenLabel('work_contact')
                                        ->placeholder('Employer Contact')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('work_address')
                                        ->hiddenLabel('work_address')
                                        ->placeholder('Employer Address')
                                        ->required()
                                        ->columnSpan(4),

                                        FileUpload::make('attachment')
                                        ->disk('public')
                                        ->directory('attachments')
                                        ->label('Select Attachment')
                                        ->required()
                                        ->columnSpanFull(),
                                ])->columnSpanFull()->columns(6),

                            Fieldset::make('family')->hiddenLabel('family')
                                ->schema([
                                        Checkbox::make('family')
                                        ->label('Family Member')
                                        ->columnSpanFull(),
                                        TextInput::make('family_mmname')
                                        ->hiddenLabel('family_mmname')
                                        ->placeholder('Name')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('family_mmrs')
                                        ->hiddenLabel('family_mmrs')
                                        ->placeholder('Relationship')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('family_mmdob')
                                        ->hiddenLabel('family_mmdob')
                                        ->placeholder('Date of Birth')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('occupation')
                                        ->hiddenLabel('occupation')
                                        ->placeholder('Occupation')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('family_mmphone')
                                        ->hiddenLabel('family_mmphone')
                                        ->placeholder('Phone No')
                                        ->required()
                                        ->columnSpan(2),
                                        TextInput::make('family_mmaddress')
                                        ->hiddenLabel('family_mmaddress')
                                        ->placeholder('Address')
                                        ->required()
                                        ->columnSpan(6),
                                ])->columns(8)->columnSpanFull(),

                            Fieldset::make('Reference')->hiddenLabel('Reference')
                            ->schema([
                                Checkbox::make('reference')
                                ->label('Reference Person')
                                ->columnSpanFull(),
                                TextInput::make('ref_person')
                                ->hiddenLabel('ref_person')
                                ->placeholder('Name')
                                ->required()
                                ->columnSpan(2),
                                TextInput::make('job_pos')
                                ->hiddenLabel('job_pos')
                                ->placeholder('Job Position')
                                ->required()
                                ->columnSpan(2),
                                TextInput::make('ref_email')
                                ->hiddenLabel('ref_email')
                                ->placeholder('Email')
                                ->required()
                                ->columnSpan(2),
                                TextInput::make('ref_phone')
                                ->hiddenLabel('ref_phone')
                                ->placeholder('Phone')
                                ->required()
                                ->columnSpan(2),
                            ])->columns(8)->columnSpanFull(),

                            Fieldset::make('TAX')->hiddenLabel('TAX')
                                ->schema([
                                    Checkbox::make('tax')
                                    ->label('Tax Payer')
                                    ->columnSpanFull(),
                                    TextInput::make('tax_employer')
                                    ->hiddenLabel('tax_employer')
                                    ->placeholder('Employer')
                                    ->required()
                                    ->columnSpan(2),

                            ])->columns(8)->columnSpanFull(),
                        ])->columns(6),

                    Step::make('Address Info')
                        ->schema([

                            Fieldset::make('Address')
                                    ->schema([
                                        Select::make('country')
                                            ->placeholder('Country')
                                            ->placeholder('Country')
                                            ->required()
                                            ->columnSpan(1)
                                            ->options([
                                                'mm' => 'Myanmar',
                                                'uk' => 'UK',
                                                'jp' => 'Japan',
                                            ]),
                                        Select::make('state')
                                            ->placeholder('State')
                                            ->required()
                                            ->columnSpan(1)
                                            ->options([
                                                'yangon' => 'Rangoon',
                                                'mandalay' => 'Mandalay',
                                                'sagai' => 'Sagai',
                                                'chin' => 'Chin',
                                                'kachin' => 'Kachin',
                                                'kayah' => 'Kayah',
                                                'kayin' => 'Kayin',
                                                'Mon' => 'Mon',
                                                'rakhine' => 'Rakhine',
                                                'shan' => 'Shan',
                                                'la' => 'LA',
                                                'sanfransico' => 'Sanfransico',
                                                'newyork' => 'Newyork',
                                                'naga' => 'Naga',
                                                'osaka' => 'Osaka',
                                                'hiroshima' => 'Hiroshima',
                                            ]),
                                        Select::make('township')
                                            ->placeholder('Township')
                                            ->placeholder('Township')
                                            ->required()
                                            ->columnSpan(1)
                                            ->options([
                                                'north_okklapa' => 'North-Okklapa',
                                                'chicago' => 'Chicago',
                                                'wano' => 'Wano',
                                            ]),
                                        TextInput::make('st_address')
                                            ->label('Street Address')
                                            ->placeholder('Street Address')
                                            ->required()
                                            ->columnSpan(1),
                                    ])->columnSpanFull()->columns(2)
                        ])->columnSpanFull()->columns(2),
                ])->columnSpanFull()
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([

    // first
            TextColumn::make('eng_name')->sortable()->toggleable(),
            TextColumn::make('mm_name')->sortable()->toggleable(),
            TextColumn::make('pap_name')->sortable()->toggleable(isToggledHiddenByDefault:true),

            TextColumn::make('dob')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('race')->sortable()->toggleable(isToggledHiddenByDefault:true),

            TextColumn::make('driver_license')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('home_phone')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('mobile_phone')->sortable()->toggleable(),

            TextColumn::make('Gender')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('Marital_Status')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('Passport_NO')->sortable()->toggleable(isToggledHiddenByDefault:true),

            TextColumn::make('nrc_code_id')->label('nrc_id')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('nrc.name_en')->sortable()->toggleable(isToggledHiddenByDefault:true),

            TextColumn::make('vacancy.vacancy_name')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('religion_id')->sortable()->toggleable(),
            TextColumn::make('vacancy.vacancy_name')->sortable()->toggleable(isToggledHiddenByDefault:true),
            TextColumn::make('blood_id')->sortable()->toggleable(),
            TextColumn::make('nationality_id')->sortable()->toggleable(),

        // second

                TextColumn::make('education.degree')->label('Degree')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('education.from')->label('From')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('education.to')->label('To')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('education.school')->label('School')->sortable()->toggleable(isToggledHiddenByDefault:true),

                TextColumn::make('work_exp.job_title')->label('Job Title')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('work_exp.company_name')->label('Company Name')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('work_exp.work_from')->label('Work From')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('work_exp.work_to')->label('Work To')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('work_exp.work_contact')->label('Work Contact')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('work_exp.work_address')->label('Work Address')->sortable()->toggleable(isToggledHiddenByDefault:true),
                ImageColumn::make('work_exp.attachment')->toggleable(),

                TextColumn::make('ref_person')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('job_pos')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('ref_email')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('ref_phone')->sortable()->toggleable(isToggledHiddenByDefault:true),

                // CheckboxColumn::make('family')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('family_mmname')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('family_mmrs')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('family_mmdob')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('occupation')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('family_mmphone')->sortable()->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('family_mmaddress')->sortable()->toggleable(isToggledHiddenByDefault:true),

                // CheckboxColumn::make('tax')->toggleable(isToggledHiddenByDefault:true),
                TextColumn::make('tax_employer')->sortable()->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->icon('heroicon-o-eye')
                ->iconButton(),
                Tables\Actions\EditAction::make('edit')
                ->icon('heroicon-m-pencil-square')
                ->iconButton(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInfos::route('/'),
            'create' => Pages\CreateInfo::route('/create'),
            'edit' => Pages\EditInfo::route('/{record}/edit'),
        ];
    }
}
