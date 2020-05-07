<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(LogCategorySeeder::class);
        $this->call(StudyLevelSeeder::class);
        $this->call(StudyPartSeeder::class);
        $this->call(StudyTypeSeeder::class);
        $this->call(SocialStatusSeeder::class);
        $this->call(IDTypeSeeder::class);
        $this->call(QualificationSeeder::class);
        $this->call(FamilyClassificationSeeder::class);
        $this->call(FamilyProjectSeeder::class);
        $this->call(FamilyStatusSeeder::class);
        $this->call(FamilyTypeSeeder::class);
        $this->call(SponsorStatusSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(DiseaseSeeder::class);
        $this->call(EducationaInstitutionSeeder::class);
        $this->call(FileTypeSeeder::class);
        $this->call(FundedInstitutionSeeder::class);
        $this->call(HouseStatusSeeder::class);
        $this->call(HouseOwnershipSeeder::class);
        $this->call(HouseRoofSeeder::class);
        $this->call(IncomeTypeSeeder::class);
        $this->call(JobTypeSeeder::class);
        $this->call(UniversitySpecialtieSeeder::class);
        $this->call(VisitReasonSeeder::class);
        $this->call(RelationshipSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(GovernorateSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(NeighborhoodSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(QualificationLevelSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(MonthTableSeeder::class);
        $this->call(TranslationSeeder::class);
        $this->call(NeedSeeder::class);
        $this->call(HealthSeeder::class);
        $this->call(GenderSeeder::class);
        $this->call(WorkSeeder::class);
        $this->call(CouponTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(PriceAndAmountSeeder::class);
        $this->call(ItemTypeSeeder::class);


    }
}